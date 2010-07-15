<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityEventPluginEventCommentActions
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class opCommunityTopicPluginEventCommentActions extends sfActions
{
  /**
   * preExecute
   */
  public function preExecute()
  {
    $object = $this->getRoute()->getObject();

    if ($object instanceof CommunityEvent)
    {
      $this->communityEvent = $object;
      $this->community = $this->communityEvent->getCommunity();
    }
    elseif ($object instanceof CommunityEventComment)
    {
      $this->communityEventComment = $object;
      $this->communityEvent = $this->communityEventComment->getCommunityEvent();
      $this->community = $this->communityEvent->getCommunity();
    }
  }

  /**
   * Executes create action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate($request)
  {
    $this->forward404Unless($this->communityEvent->isCreatableCommunityEventComment($this->getUser()->getMemberId()));

    $this->form = new CommunityEventCommentForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunityEvent($this->communityEvent);
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    if ($this->form->isValid())
    {
      try
      {
        if (!$request->getParameter('comment'))
        {
          $this->form->getObject()->toggleEventMember($this->getUser()->getMemberId());
        }

        $this->form->save();
        $this->redirect('@communityEvent_show?id='.$this->communityEvent->getId());
      }
      catch (opCommunityEventMemberAppendableException $e)
      {
        $this->getUser()->setFlash('error', $e->getMessage());
      }
    }

    $this->setTemplate('../../communityEvent/templates/show');

    return sfView::SUCCESS;
  }

  /**
   * Executes delete confirm action
   *
   * @param sfRequest $request A redirect object
   */
  public function executeDeleteConfirm($request)
  {
    $this->forward404Unless($this->communityEventComment->isDeletable($this->getUser()->getMemberId()));

    $this->form = new sfForm();

    return sfView::SUCCESS;
  }

  /**
   * Executes delete action
   *
   * @param sfRequest $request A redirect object
   */
  public function executeDelete($request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($this->communityEventComment->isDeletable($this->getUser()->getMemberId()));

    $this->communityEventComment->delete();

    $this->getUser()->setFlash('notice', 'The comment was deleted successfully.');

    $this->redirect('@communityEvent_show?id='.$this->communityEvent->getId());
  }
}
