<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginEventActions
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class opCommunityTopicPluginEventActions extends sfActions
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
      elseif ($object instanceof CommunityEvent)
      {
        $this->communityEvent = $object;
        $this->community = $this->communityEvent->getCommunity();
        $this->acl = opCommunityTopicAclBuilder::buildResource($this->communityEvent, array($this->getUser()->getMember()));
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
    $this->forwardIf($request->isSmartphone(), 'communityEvent', 'smtListCommunity');

    if (!$this->size)
    {
      $this->size = 20;
    }

    $this->pager = Doctrine::getTable('CommunityEvent')->getCommunityEventListPager(
      $this->community->getId(),
      $request->getParameter('page'),
      $this->size
    );

    return sfView::SUCCESS;
  }

  public function executeSmtListCommunity($request)
  {
    $this->id = $this->community->getId();
    $this->isEventCreatable = $this->acl->isAllowed($this->getUser()->getMemberId(), null, 'add');

    return sfView::SUCCESS;
  }

  /**
   * Executes show action
   *
   * @param sfRequest $request A request object
   */
  public function executeShow($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'view'));
    $this->forwardIf($request->isSmartphone(), 'communityEvent', 'smtShow');

    $this->form = new CommunityEventCommentForm();

    return sfView::SUCCESS;
  }

  public function executeSmtShow($request)
  {
    $this->id = $this->communityEvent->getId();
    $this->isCommentCreatable = $this->communityEvent->isCreatableCommunityEventComment($this->getUser()->getMember()->getId());
    $this->isEditable = $this->communityEvent->isEditable($this->getUser()->getMember()->getId());
    opSmartphoneLayoutUtil::setLayoutParameters(array('community' => $this->community));

    return sfView::SUCCESS;
  }
  /**
   * Executes memberList action
   *
   * @param sfRequest $request A request object
   */
  public function executeMemberList($request)
  {
    $this->forward404Unless($this->acl->isAllowed($this->getUser()->getMemberId(), null, 'view'));
    $this->forwardIf($request->isSmartphone(), 'communityEvent', 'smtMemberList');

    if (!$this->size)
    {
      $this->size = 20;
    }
    $this->pager = Doctrine::getTable('CommunityEvent')->getEventMemberListPager($this->communityEvent->getId(), $request->getParameter('page', 1), $this->size);

    if (!$this->pager->getNbResults()) {
      return sfView::ERROR;
    }
  }

  public function executeSmtMemberList($request)
  {
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
    $this->forwardIf($request->isSmartphone(), 'communityEvent', 'smtNew');

    $this->form = new CommunityEventForm();

    return sfView::SUCCESS;
  }

  /**
   * Executes new action
   *
   * @param sfRequest $request A request object
   */
  public function executeSmtNew($request)
  {
    $this->event = null;
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
    $this->forwardIf($request->isSmartphone(), 'communityEvent', 'smtCreate');

    $this->form = new CommunityEventForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunity($this->community);
    $this->processForm($request, $this->form);

    $this->setTemplate('new');

    return sfView::SUCCESS;
  }

  public function executeSmtCreate($request)
  {
    $this->communityId = $this->community->getId();
    $this->form = new CommunityEventForm();
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
    $this->forward404Unless($this->communityEvent->isEditable($this->getUser()->getMemberId()));

    $this->form = new CommunityEventForm($this->communityEvent);

    return sfView::SUCCESS;
  }

  /**
   * Executes update action
   *
   * @param sfRequest $request A request object
   */
  public function executeUpdate($request)
  {
    $this->forward404Unless($this->communityEvent->isEditable($this->getUser()->getMemberId()));

    $this->form = new CommunityEventForm($this->communityEvent);
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');

    return sfView::SUCCESS;
  }


  /**
   * Executes deleteConfirm action
   *
   * @param sfRequest $request A request object
   */
  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->forward404Unless($this->communityEvent->isEditable($this->getUser()->getMemberId()));

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

    $this->forward404Unless($this->communityEvent->isEditable($this->getUser()->getMemberId()));

    $this->communityEvent->delete();

    $this->getUser()->setFlash('notice', 'The %community% event was deleted successfully.');

    $this->redirect('community/home?id='.$this->community->getId());
  }

  /**
   * Executes recentlyEventList
   *
   * @param sfRequest $request A request object
   */
  public function executeRecentlyEventList($request)
  {
    if (!$this->size)
    {
      $this->size = 50;
    }

    $this->pager = Doctrine::getTable('CommunityEvent')->getRecentlyEventListPager(
      $this->getUser()->getMemberId(),
      $request->getParameter('page', 1),
      $this->size
    );

    return sfView::SUCCESS;
  }

  protected function processForm($request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName()),
      $request->getFiles($form->getName())
    );

    if ($form->isValid())
    {
      $communityEvent = $form->save();

      $this->redirect('@communityEvent_show?id='.$communityEvent->getId());
    }
  }

  protected function smtPost(sfWebRequest $request)
  {
    $this->communityId = $this->community->getId();
    $this->form = new CommunityEventForm();
    $this->setLayout('smtLayoutSns');
    $this->setTemplate('smtPost');
  }
}
