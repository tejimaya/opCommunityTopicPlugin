<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityTopic actions.
 *
 * @package    OpenPNE
 * @subpackage communityTopic
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class communityTopicActions extends sfActions
{
  public function preExecute()
  {
    $object = $this->getRoute()->getObject();

    if ($object instanceof Community)
    {
      $this->community = $object;
    }
    elseif ($object instanceof CommunityTopic)
    {
      $this->communityTopic = $object;
      $this->community = $this->communityTopic->getCommunity();
    }
  }

  public function postExecute()
  {
    sfConfig::set('sf_nav_type', 'community');
    sfConfig::set('sf_nav_id', $this->community->getId());
  }

 /**
  * Executes listCommunity action
  *
  * @param sfRequest $request A request object
  */
  public function executeListCommunity(sfWebRequest $request)
  {
    $this->forward404Unless($this->community->isViewableCommunityTopic($this->getUser()->getMemberId()));

    $this->pager = CommunityTopicPeer::getCommunityTopicListPager($this->community->getId(), $request->getParameter('page'), 20);
  }

 /**
  * Executes show action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($this->community->isViewableCommunityTopic($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicCommentForm();
  }

 /**
  * Executes new action
  *
  * @param sfRequest $request A request object
  */
  public function executeNew(sfWebRequest $request)
  {
    $this->forward404Unless($this->community->isCreatableCommunityTopic($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicForm();
  }

 /**
  * Executes create action
  *
  * @param sfRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->community->isCreatableCommunityTopic($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicForm();
    $this->form->getObject()->setMemberId($this->getUser()->getMemberId());
    $this->form->getObject()->setCommunity($this->community);
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

 /**
  * Executes edit action
  *
  * @param sfRequest $request A request object
  */
  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($this->communityTopic->isEditable($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicForm($this->communityTopic);
  }

 /**
  * Executes update action
  *
  * @param sfRequest $request A request object
  */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($this->communityTopic->isEditable($this->getUser()->getMemberId()));

    $this->form = new CommunityTopicForm($this->communityTopic);
    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

 /**
  * Executes deleteConfirm action
  *
  * @param sfRequest $request A request object
  */
  public function executeDeleteConfirm(sfWebRequest $request)
  {
    $this->forward404Unless($this->communityTopic->isEditable($this->getUser()->getMemberId()));

    $this->form = new sfForm();
  }

 /**
  * Executes delete action
  *
  * @param sfRequest $request A request object
  */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($this->communityTopic->isEditable($this->getUser()->getMemberId()));

    $this->communityTopic->delete();

    $this->getUser()->setFlash('notice', 'The community topic was deleted successfully.');

    $this->redirect('community/home?id='.$this->community->getId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind(
      $request->getParameter($form->getName())
    );

    if ($form->isValid())
    {
      $communityTopic = $form->save();

      $this->redirect('@communityTopic_show?id='.$communityTopic->getId());
    }
  }
}
