<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityTopicComment actions.
 *
 * @package    OpenPNE
 * @subpackage communityTopicComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class communityTopicCommentActions extends sfActions
{
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

  public function postExecute()
  {
    sfConfig::set('sf_nav_type', 'community');
    sfConfig::set('sf_nav_id', $this->community->getId());
  }

 /**
  * Executes create action
  *
  * @param sfRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->communityTopic->isCreatableCommunityTopicComment($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicCommentForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunityTopic($this->communityTopic);
    $this->form->bind($request->getParameter($this->form->getName()));
    if ($this->form->isValid())
    {
      $this->form->save();
      $this->redirect('@communityTopic_show?id='.$this->communityTopic->getId());
    }

    $this->setTemplate('../../communityTopic/templates/show');
  }

  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->forward404Unless($this->communityTopicComment->isDeletable($this->getUser()->getMemberId()));

    $this->form = new sfForm();
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($this->communityTopicComment->isDeletable($this->getUser()->getMemberId()));

    $this->communityTopicComment->delete();

    $this->getUser()->setFlash('notice', 'The comment was deleted successfully.');

    $this->redirect('@communityTopic_show?id='.$this->communityTopic->getId());
  }
}
