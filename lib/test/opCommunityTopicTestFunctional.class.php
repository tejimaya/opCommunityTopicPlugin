<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * functional test class for OpenPNE.
 *
 * @package    OpenPNE
 * @subpackage test
 * @author     Eitarow Fukamachi <e.arrows@gmail.com>
 */
class opCommunityTopicTestFunctional extends opTestFunctional
{
  protected
    $lastScenario = null;

  public function checkDispatch($module, $action)
  {
    return
      $this->with('request')->begin()
        ->isParameter('module', $module)
        ->isParameter('action', $action)
      ->end();
  }

  public function isStatusCode($code)
  {
    return $this->with('response')->isStatusCode($code);
  }

  public function get($url)
  {
    parent::get($url);
    switch(true)
    {
    case (preg_match('/^\/?community\/\d+$/', $url)):
      $module = 'community';
      $action = 'home';
      break;
    case (preg_match('/^\/?communityTopic\/\d+$/', $url)):
      $module = 'communityTopic';
      $action = 'show';
      break;
    case (preg_match('/^\/?communityTopic\/comment\/deleteConfirm/', $url)):
      $module = 'communityTopicComment';
      $action = 'deleteConfirm';
      break;
    case (preg_match('/^\/?([^\/]+)\/([^\/]+)\/?/', $url, $match)):
      $module = $match[1];
      $action = $match[2];
      break;
    }

    return $this->checkDispatch($module, $action);
  }

  public function isRedirectForLoginOr404()
  {
    if (404 === $this->getResponse()->getStatusCode())
    {
      $this->isStatusCode(404);
    }
    else
    {
      $this->with('response')->isStatusCode(200);
      if ($this->getResponse()->getHttpHeader('location'))
      {
        $this->followRedirect()
          ->checkDispatch('member', 'login');
      }
      else
      {
        $this->isForwardedTo('member', 'login');
      }
    }

    return $this;
  }

  private function isAllowed($resource, $action)
  {
    if (!isset($this->lastScenario[$resource]['allow']))
    {
      return false;
    }

    if (in_array($action, array('add', 'edit', 'delete')) && in_array('update', $this->lastScenario[$resource]['allow']))
    {
      return true;
    }

    return (bool) in_array($action, $this->lastScenario[$resource]['allow']);
  }

  private function detectCommunity()
  {
    $publicFlag = $this->lastScenario['community']['public_flag'];
    $topicAuthority = $this->lastScenario['community']['topic_authority'];

    $communities = Doctrine::getTable('CommunityConfig')->createQuery()
      ->select('community_id')
      ->where('name = ?', 'public_flag')
      ->andWhere('value = ?', $publicFlag)
      ->execute(array(), Doctrine::HYDRATE_ARRAY);

    if (0 === count($communities))
    {
      throw new Exception(sprintf('"Community" not found. Wrong fixture? (public_flag: %s, topic_authority: %s)', $publicFlag, $topicAuthority));
    }

    $communityIds = array_map(create_function('$e', 'return $e["community_id"];'), $communities);

    $detected = Doctrine::getTable('CommunityConfig')->createQuery()
      ->select('community_id')
      ->whereIn('community_id', $communityIds)
      ->andWhere('name = ?', 'topic_authority')
      ->andWhere('value = ?', $topicAuthority)
      ->fetchOne();

    if ($detected)
    {
      return $detected['community_id'];
    }

    throw new Exception(sprintf('"Community" not found. Wrong fixture? (public_flag: %s, topic_authority: %s)', $publicFlag, $topicAuthority));
  }

  private function detectCommunityTopic($communityId)
  {
    $adminId = Doctrine::getTable('CommunityMemberPosition')->findOneByCommunityIdAndName($communityId, 'admin')->getMemberId();
    $q = Doctrine::getTable('CommunityTopic')->createQuery()
      ->where('community_id = ?', $communityId);

    switch($this->lastScenario['communityTopic']['author'])
    {
    case "admin":
      $q->andWhere('member_id = ?', $adminId);
      break;
    case "self":
      $q->andWhere('member_id = ?', sfContext::getInstance()->getUser()->getMemberId());
      break;
    case "other":
      $q->andWhere('member_id <> ?', $adminId)
        ->andWhere('member_id <> ?', sfContext::getInstance()->getUser()->getMemberId());
      break;
    }

    if ($detected = $q->fetchOne())
    {
      return $detected->getId();
    }

    throw new Exception(sprintf('"Community Topic" added by "%s" not found. Wrong fixture? (communityId: %d, adminId: %d)', $this->lastScenario['communityTopic']['author'], $communityId, $adminId));
  }

  private function detectCommunityTopicComment($communityTopicId)
  {
    $q = Doctrine::getTable('CommunityTopicComment')->createQuery()
      ->where('community_topic_id = ?', $communityTopicId);

    if ($detected = $q->fetchOne())
    {
      return $detected->getId();
    }

    throw new Exception(sprintf('"Community Topic Comment" not found. Wrong fixture? (communityTopicId: %d)', $communityTopicId));
  }

  public function scenario($p = array())
  {
    $this->lastScenario = $p;

    $communityId = $this->detectCommunity();
    $communityTopicId = $this->detectCommunityTopic($communityId);
    $communityTopicCommentId = $this->detectCommunityTopicComment($communityTopicId);

    $this->get('/community/'.$communityId);
    if ($this->isAllowed('community', 'view'))
    {
      $this->with('response')->begin()
        ->isStatusCode(200)
        ->checkElement('#communityHome th:contains("コミュニティトピック")', $this->isAllowed('communityTopic', 'view'))
        ->checkElement('#communityHome td a:contains("トピックを作成する")', $this->isAllowed('communityTopic', 'add'))
      ->end();
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    $this->get('/communityTopic/listCommunity/'.$communityId);
    if ($this->isAllowed('communityTopic', 'view'))
    {
      $this->with('response')->begin()
        ->isStatusCode(200)
        ->checkElement('#communityTopicList h3:contains("トピックを作成する")', $this->isAllowed('communityTopic', 'add'))
        ->checkElement('.recentList dd a', true, array('count' => $this->lastScenario['communityTopic']['num']))
      ->end();
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    $this->get('/communityTopic/'.$communityTopicId);
    if ($this->isAllowed('communityTopic', 'view'))
    {
      $this->with('response')->begin()
        ->isStatusCode(200)
        ->checkElement('.topicDetailBox .operation input[value="編集"]', $this->isAllowed('communityTopic', 'edit'))
        ->checkElement('.commentList div:contains("削除")', $this->isAllowed('communityTopic', 'edit'))
        ->checkElement('#formCommunityTopicComment h3:contains("コメントを書く")', $this->isAllowed('communityTopicComment', 'add'))
      ->end();
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    if ($this->isAllowed('communityTopicComment', 'add'))
    {
      $this->click('送信', array('community_topic_comment' => array(
        'body' => 'test',
      )))
      ->checkDispatch('communityTopicComment', 'create');
    }

    $this->get('/communityTopic/new/'.$communityId);
    if ($this->isAllowed('communityTopic', 'add'))
    {
      $this->isStatusCode(200)
        ->click('送信', array('community_topic' => array(
          'name' => 'test',
          'body' => 'test',
        )))
        ->checkDispatch('communityTopic', 'create');
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    $this->get('/communityTopic/edit/'.$communityTopicId);
    if ($this->isAllowed('communityTopic', 'edit'))
    {
      $this->isStatusCode(200)
        ->click('送信')
        ->checkDispatch('communityTopic', 'update');
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    $this->get('/communityTopic/comment/deleteConfirm/'.$communityTopicCommentId);
    if ($this->isAllowed('communityTopicComment', 'delete'))
    {
      $this->isStatusCode(200)
        ->click('削除')
        ->checkDispatch('communityTopicComment', 'delete');
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    $this->get('/communityTopic/deleteConfirm/'.$communityTopicId);
    if (true === $this->isAllowed('communityTopic', 'delete'))
    {
      $this->isStatusCode(200)
        ->click('削除')
        ->checkDispatch('communityTopic', 'delete');
    }
    else
    {
      $this->isRedirectForLoginOr404();
    }

    return $this;
  }
}
