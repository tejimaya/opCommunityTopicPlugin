<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginTopicCommentActions
 *
 * @package    OpenPNE
 * @subpackage communityTopic
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Shogo Kawahara <kawahara@tejimaya.net>
 * @author     tunn <tunn@tejimaya.com>
 */
abstract class opCommunityTopicPluginTopicCommentActions extends sfActions
{
  /**
   * preExecute
   */
  public function preExecute()
  {
    $object = $this->getRoute()->getObject();

    if ($object instanceof CommunityTopic)
    {
      $this->communityTopic = $object;
      $this->community = $this->communityTopic->getCommunity();
    }
    elseif ($object instanceof CommunityTopicComment)
    {
      $this->communityTopicComment = $object;
      $this->communityTopic = $this->communityTopicComment->getCommunityTopic();
      $this->community = $this->communityTopic->getCommunity();
    }
  }

  /**
   * Executes create action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate($request)
  {
    $this->forward404Unless($this->communityTopic->isCreatableCommunityTopicComment($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicCommentForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunityTopic($this->communityTopic);
    $this->form->bind($request->getParameter($this->form->getName()), $request->getFiles($this->form->getName()));
    
    if ($this->form->isValid())
    {
      $this->form->save();
      $this->redirect('@communityTopic_show?id='.$this->communityTopic->getId());
    }

    $this->setTemplate('../../communityTopic/templates/show');

    return sfView::SUCCESS;
  }

  /**
   * Executes delete confirm action
   *
   * @param sfRequest $request A redirect object
   */
  public function executeDeleteConfirm($request)
  {
    $this->forward404Unless($this->communityTopicComment->isDeletable($this->getUser()->getMemberId()));

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

    $this->forward404Unless($this->communityTopicComment->isDeletable($this->getUser()->getMemberId()));

    $this->communityTopicComment->delete();

    $this->getUser()->setFlash('notice', 'The comment was deleted successfully.');

    $this->redirect('@communityTopic_show?id='.$this->communityTopic->getId());
  }
}
