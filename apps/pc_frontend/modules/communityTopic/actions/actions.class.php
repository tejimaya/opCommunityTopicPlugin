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
    $this->communityTopicId = $this->getRequestParameter('id');
    $this->communityTopic = CommunityTopicPeer::retrieveByPk($this->communityTopicId);

    if ($this->communityTopic)
    {
      $this->community = $this->communityTopic->getCommunity();
    } else {
      $this->community = new Community();
      $this->community->setId($this->getRequestParameter('community_id'));
    }
    if ($this->community)
    {
    $this->communityId = $this->community->getId();
    }

    $this->communityConfigTopicAuthority = CommunityConfigPeer::retrieveByNameAndCommunityId('topic_authority', $this->communityId);
    if ($this->communityConfigTopicAuthority && $this->communityConfigTopicAuthority->getValue() === 'admin_only')
    {
      $this->checkOwner = true;
    }
    else
    {
      $this->checkOwner = false;
    }
  }

 /**
  * Executes listCommunity action
  *
  * @param sfRequest $request A request object
  */
  public function executeListCommunity(sfWebRequest $request)
  {
    $this->community = $this->getRoute()->getObject();

    if ($this->community->getConfig('public_flag') === 'auth_commu_member')
    {
      $this->forward404Unless($this->community->isPrivilegeBelong($this->getUser()->getMemberId()));
    }

    $this->pager = CommunityTopicPeer::getCommunityTopicListPager($this->community->getId(), $request->getParameter('page'), 20);
  }

 /**
  * Executes show action
  *
  * @param sfRequest $request A request object
  */
  public function executeShow(sfWebRequest $request)
  {
    $this->communityTopic = $this->getRoute()->getObject();
    $this->community = $this->communityTopic->getCommunity();

    if ($this->community->getConfig('public_flag') === 'auth_commu_member')
    {
      $this->forward404Unless($this->community->isPrivilegeBelong($this->getUser()->getMemberId()));
    }

    $this->form = new CommunityTopicCommentForm();
  }

 /**
  * Executes new action
  *
  * @param sfRequest $request A request object
  */
  public function executeNew(sfWebRequest $request)
  {
    $this->community = $this->getRoute()->getObject();

    if ($this->community->getConfig('topic_authority') === 'admin_only')
    {
      $this->forward404Unless($this->community->isAdmin($this->getUser()->getMemberId()));
    }
    else
    {
      $this->forward404Unless($this->community->isPrivilegeBelong($this->getUser()->getMemberId()));
    }

    $this->form = new CommunityTopicForm();
  }

 /**
  * Executes create action
  *
  * @param sfRequest $request A request object
  */
  public function executeCreate(sfWebRequest $request)
  {
    $this->community = $this->getRoute()->getObject();

    if ($this->community->getConfig('topic_authority') === 'admin_only')
    {
      $this->forward404Unless($this->community->isAdmin($this->getUser()->getMemberId()));
    }
    else
    {
      $this->forward404Unless($this->community->isPrivilegeBelong($this->getUser()->getMemberId()));
    }

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
    $this->communityTopic = $this->getRoute()->getObject();
    $this->community = $this->communityTopic->getCommunity();

    $this->forward404Unless(
         $this->community->isAdmin($this->getUser()->getMemberId())
      || $this->communityTopic->getMemberId() === $this->getUser()->getMemberId()
    );

    $this->form = new CommunityTopicForm($this->communityTopic);
  }

 /**
  * Executes update action
  *
  * @param sfRequest $request A request object
  */
  public function executeUpdate(sfWebRequest $request)
  {
    $this->communityTopic = $this->getRoute()->getObject();
    $this->community = $this->communityTopic->getCommunity();

    $this->forward404Unless(
         $this->community->isAdmin($this->getUser()->getMemberId())
      || $this->communityTopic->getMemberId() === $this->getUser()->getMemberId()
    );

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
    $this->communityTopic = $this->getRoute()->getObject();
    $this->community = $this->communityTopic->getCommunity();

    $this->forward404Unless(
         $this->community->isAdmin($this->getUser()->getMemberId())
      || $this->communityTopic->getMemberId() === $this->getUser()->getMemberId()
    );

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

    $this->communityTopic = $this->getRoute()->getObject();
    $this->community = $this->communityTopic->getCommunity();

    $this->forward404Unless(
         $this->community->isAdmin($this->getUser()->getMemberId())
      || $this->communityTopic->getMemberId() === $this->getUser()->getMemberId()
    );

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

      $this->redirect($this->generateUrl('communityTopic_show', $communityTopic));
    }
  }
}
