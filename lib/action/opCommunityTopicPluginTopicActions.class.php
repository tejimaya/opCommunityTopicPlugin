<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginTopicActions
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Shogo Kawahara <kawahara@tejimaya.net>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
abstract class opCommunityTopicPluginTopicActions extends sfActions
{
  /**
   * preExecute
   */
  public function preExecute()
  {
    if ($this->getRoute() instanceof sfDoctrineRoute)
    {
      $object = $this->getRoute()->getObject();

      if ($object instanceof Community)
      {
        $this->community = $object;
        $this->acl = opCommunityTopicAclBuilder::buildCollection($this->community, array($this->getUser()->getMember()));
      }
      elseif ($object instanceof CommunityTopic)
      {
        $this->communityTopic = $object;
        $this->community = $this->communityTopic->getCommunity();
        $this->acl = opCommunityTopicAclBuilder::buildResource($this->communityTopic, array($this->getUser()->getMember()));
      }
    }
  }

  /**
   * Executes listCommunity action
   *
   * @param sfRequest $request A request object
   */
  public function executeListCommunity($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'view'));
    $this->forwardIf($request->isSmartphone(), 'communityTopic', 'smtListCommunity');

    if (!$this->size)
    {
      $this->size = 20;
    }

    $this->pager = Doctrine::getTable('CommunityTopic')->getCommunityTopicListPager(
      $this->community->getId(),
      $request->getParameter('page'),
      $this->size
    );

    return sfView::SUCCESS;
  }

  public function executeSmtListCommunity($request)
  {
    $this->id = $this->community->getId();
    $this->isTopicCreatable = $this->acl->isAllowed($this->getUser()->getMemberId(), null, 'add');

    return sfView::SUCCESS;
  }

  /**
   * Executes show action
   *
   * @param sfRequest $request A request object
   */
  public function executeShow($request)
  {
    $this->forwardIf($request->isSmartphone(), 'communityTopic', 'smtShow');
    $this->form = new CommunityTopicCommentForm();

    return sfView::SUCCESS;
  }

  public function executeSmtShow($request)
  {
    $this->id = $request['id'];
    $this->isCommentCreatable = $this->communityTopic->isCreatableCommunityTopicComment($this->getUser()->getMember()->getId());
    opSmartphoneLayoutUtil::setLayoutParameters(array('community' => $this->community));

    return sfView::SUCCESS;
  }
  /**
   * Executes new action
   *
   * @param sfRequest $request A request object
   */
  public function executeNew($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'add'));
    $this->forwardIf($request->isSmartphone(), 'communityTopic', 'smtNew');

    $this->form = new CommunityTopicForm();

    return sfView::SUCCESS;
  }

  public function executeSmtNew($request)
  {
    $this->topic = null;
    $this->smtPost($request);
  }

  /**
   * Executes create action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'add'));
    $this->forwardIf($request->isSmartphone(), 'communityTopic', 'smtCreate');

    $this->form = new CommunityTopicForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunity($this->community);
    $this->processForm($request, $this->form);

    $this->setTemplate('new');

    return sfView::SUCCESS;
  }

  public function executeSmtCreate($request)
  {
    $this->communityId = $this->community->getId();
    $this->form = new CommunityTopicForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunity($this->community);
    $this->processForm($request, $this->form);

    $this->setLayout('smtLayoutSns');
    $this->setTemplate('smtPost');

    return sfView::SUCCESS;
  }

  /**
   * Executes edit action
   *
   * @param sfRequest $request A request object
   */
  public function executeEdit($request)
  {
    $this->forwardIf($request->isSmartphone(), 'communityTopic', 'smtEdit');
    $this->form = new CommunityTopicForm($this->communityTopic);

    return sfView::SUCCESS;
  }


  public function executeSmtEdit($request)
  {
    $this->topic = Doctrine::getTable('CommunityTopic')->findOneById($request['id']);
    $this->forward404Unless($this->topic->isEditable($this->getUser()->getMemberId()));

    $this->communityId = $this->community->getId();
    $this->form = new CommunityTopicForm($this->communityTopic);
    $this->setLayout('smtLayoutSns');
    $this->setTemplate('smtEdit');
  }

  /**
   * Executes update action
   *
   * @param sfRequest $request A request object
   */
  public function executeUpdate($request)
  {
    $this->forwardIf($request->isSmartphone(), 'communityTopic', 'smtUpdate');

    $this->form = new CommunityTopicForm($this->communityTopic);
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');

    return sfView::SUCCESS;
  }

  /**
   * Executes update action
   *
   * @param sfRequest $request A request object
   */
  public function executeSmtUpdate($request)
  {
    $this->form = new CommunityTopicForm($this->communityTopic);
    $this->processForm($request, $this->form);
    $this->setLayout('smtLayoutSns');
    $this->setTemplate('smtEdit');

    return sfView::SUCCESS;
  }

  /**
   * Executes deleteConfirm action
   *
   * @param sfRequest $request A request object
   */
  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->form = new sfForm();

    return sfView::SUCCESS;
  }

  /**
   * Executes delete action
   *
   * @param sfRequest $request A request object
   */
  public function executeDelete($request)
  {
    $request->checkCSRFProtection();

    $this->communityTopic->delete();

    $this->getUser()->setFlash('notice', 'The %community% topic was deleted successfully.');

    $this->redirect('community/home?id='.$this->community->getId());
  }

  /**
   * Executes recentlyTopicList
   *
   * @param sfRequest $request A request object
   */
  public function executeRecentlyTopicList($request)
  {
    if (!$this->size)
    {
      $this->size = 50;
    }

    $this->pager = Doctrine::getTable('CommunityTopic')->getRecentlyTopicListPager(
      $this->getUser()->getMemberId(),
      $request->getParameter('page', 1),
      $this->size
    );

    return sfView::SUCCESS;
  }

  /**
   * Executes search action
   *
   * @param sfRequest $request A request object
   */
  public function executeSearch($request)
  {
    $params = array(
      'keyword' => $request->getParameter('keyword'),
      'target' => $request->getParameter('target', 'in_community'),
      'type' => $request->getParameter('type', 'topic'),
    );

    $this->form = new PluginCommunityTopicSearchForm();
    $this->form->bind($params);

    if ('event' === $request->getParameter('type'))
    {
      $table = Doctrine::getTable('CommunityEvent');
      $this->link_to_detail = 'communityEvent/show?id=%d';
      $this->type = 'event';
    }
    else
    {
      $table = Doctrine::getTable('CommunityTopic');
      $this->link_to_detail = 'communityTopic/show?id=%d';
      $this->type = 'topic';
    }

    $this->communityId = $request->getParameter('id');
    $this->pageUrl = '@communityTopic_search';
    if (!$request->hasParameter('id'))
    {
      unset($this->form['target']);
      $this->pageUrl .= '_all';
    }
    else
    {
      $this->pageUrl .= '?id='.$this->communityId;
    }

    $q = $table->getSearchQuery($request->getParameter('id'), $request->getParameter('target'), $request->getParameter('keyword'), $this->getUser()->getMemberId());
    $this->pager = $table->getResultListPager($q, $request->getParameter('page'));

    $this->isResult = false;
    if (null !== $request->getParameter('keyword') || null !== $request->getParameter('target') || null !== $request->getParameter('type'))
    {
      $this->isResult = true;
    }

    return sfView::SUCCESS;
  }

  public function executeConfigNotificationMail($request)
  {
    $form = new opConfigCommunityTopicNotificationMailForm($request['id']);

    $form->bind($request['topic_notify']);
    if ($form->isValid())
    {
      $form->save();
      $this->getUser()->setFlash('notice', 'Configuring was successfull.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'Failed to configure.');
    }

    $this->redirect('@community_home?id='.$request['id']);
  }

  protected function processForm($request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName()),
      $request->getFiles($form->getName())
    );

    if ($form->isValid())
    {
      $communityTopic = $form->save();
      $this->redirect('@communityTopic_show?id='.$communityTopic->getId());
    }
  }

  protected function smtPost(sfWebRequest $request)
  {
    $this->communityId = $this->community->getId();
    $this->form = new CommunityTopicForm();
    $this->setLayout('smtLayoutSns');
    $this->setTemplate('smtPost');
  }
}
