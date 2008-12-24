<?php

/**
 * communityTopic actions.
 *
 * @package    OpenPNE
 * @subpackage communityTopic
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
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
    $this->communityId = $this->community->getId();

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
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
  }

 /**
  * Executes edit action
  *
  * @param sfRequest $request A request object
  */
  public function executeEdit($request)
  {
    $this->community->checkPrivilegeBelong($this->getUser()->getMemberId());
    if ($this->checkOwner)
    {
      $this->community->checkPrivilegeOwner($this->getUser()->getMemberId());
    }

    $this->form = new CommunityTopicForm($this->communityTopic, array('community_id' => $this->communityId));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('community_topic'));
      if ($this->form->isValid())
      {
        $communityTopic = $this->form->save();
        $this->redirect('community/home?id='.$this->communityId);
      }
    }
  }

 /**
  * Executes detail action
  *
  * @param sfRequest $request A request object
  */
  public function executeDetail($request)
  {
    $this->communityConfigPublicFlag = CommunityConfigPeer::retrieveByNameAndCommunityId('public_flag', $this->communityId);
    if ($this->communityConfigPublicFlag && $this->communityConfigPublicFlag->getValue() === 'auth_commu_member')
    {
      $this->community->checkPrivilegeBelong($this->getUser()->getMemberId());
    }

    $this->comments = CommunityTopicCommentPeer::retrieveByCommunityTopicId($this->communityTopicId);
    $this->comment = CommunityTopicCommentPeer::retrieveByPk($request->getParameter('comment_id'));

    $this->form = new CommunityTopicCommentForm($this->comment, array('community_topic_id' => $this->communityTopicId));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('community_topic_comment'));
      if ($this->form->isValid())
      {
        $communityTopicComment = $this->form->save();
        $this->redirect('communityTopic/detail?id='.$this->communityTopicId);
      }
    }
  }

 /**
  * Executes delete action
  *
  * @param sfRequest $request A request object
  */
  public function executeDelete($request)
  {
    $this->community->checkPrivilegeBelong($this->getUser()->getMemberId());
    if ($this->checkOwner)
    {
      $this->community->checkPrivilegeOwner($this->getUser()->getMemberId());
    }

    $this->comments = CommunityTopicCommentPeer::retrieveByCommunityTopicId($this->communityTopicId);

    foreach ($this->comments as $comment)
    {
      echo $comment->delete();
    }

    $this->communityTopic->delete();
    $this->redirect('community/home?id='.$this->communityId);
  }
}
