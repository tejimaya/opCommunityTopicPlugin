<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * community topic api actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Shunsuke Watanabe <watanabe@craftgear.net>
 */
class communityTopicActions extends opJsonApiActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->member = $this->getUser()->getMember();
  }

  public function executeSearch(sfWebRequest $request)
  {
    if ($request['format'] == 'mini')
    {
      $this->forward400If(!isset($request['community_id']) || '' === (string)$request['community_id'], 'community id is not specified');

      $page = isset($request['page']) ? $request['page'] : 1;
      $limit = isset($request['limit']) ? $request['limit'] : sfConfig::get('op_json_api_limit', 15);

      $query = Doctrine::getTable('CommunityTopic')->createQuery('t')
        ->where('community_id = ?', $request['community_id'])
        ->orderBy('topic_updated_at desc')
        ->offset(($page - 1) * $limit)
        ->limit($limit);

      $this->topics = $query->execute();
      $total = $query->count();
      $this->next = false;
      if ($total > $page * $limit)
      {
        $this->next = $page + 1;
      }
    }
    else
    {
      $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'id is not specified');

      $this->memberId = $this->getUser()->getMemberId();
      $this->topic = Doctrine::getTable('CommunityTopic')->findOneById($request['id']);
    
      $this->setTemplate('show');
    }
  }

}
