<?php

/**
 * community_topic actions.
 *
 * @package    OpenPNE
 * @subpackage community_topic
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class community_topicActions extends sfActions
{
  public function preExecute()
  {
    $this->community_topic_id = $this->getRequestParameter('id');

//    $this->isCommunityMember = CommunityMemberPeer::isMember($this->getUser()->getMemberId(), $this->community_topic_id);
//    $this->isAdmin = CommunityMemberPeer::isAdmin($this->getUser()->getMemberId(), $this->community_topic_id);
//    $this->isEditCommunity = $this->isAdmin;
  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
    //$this->forward('default', 'module');
  }

 /**
  * Executes edit action
  *
  * @param sfRequest $request A request object
  */
  public function executeEdit($request)
  {
/*
    if ($this->community_topic_id && !$this->isEditCommunity)
    {
      $this->forward('default', 'secure');
    }
*/

    $this->community_topic = CommunityTopicPeer::retrieveByPk($this->community_topic_id);
    if ($this->community_topic)
    {
      $this->community_id = $this->community_topic->getCommunityId();
    } else {
      $this->community_id = $this->getRequestParameter('community_id');
    }
    $this->form = new CommunityTopicForm($this->community_topic, array('community_id' => $request->getParameter('community_id')));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('community_topic'));
      if ($this->form->isValid())
      {
        $community_topic = $this->form->save();
//        $this->redirect('community/edit?id=' . $community_topic->getId());
        //$this->redirect('community/?id=' . $request->getParameter('community_id'));
        $this->redirect('community/home?id='.$this->community_id);

      }
    }

/*
    if (!$this->community_topic) {
      sfConfig::set('sf_navi_type', 'default');
    }
*/
  //  return $result;
  }

 /**
  * Executes detail action
  *
  * @param sfRequest $request A request object
  */
  public function executeDetail($request)
  {
    $this->community_topic = CommunityTopicPeer::retrieveByPk($this->community_topic_id);
    $this->comments = CommunityTopicCommentPeer::retrieveByCommunityTopicId($this->community_topic_id);
    $this->comment = CommunityTopicCommentPeer::retrieveByPk($request->getParameter('comment_id'));


    $this->form = new CommunityTopicCommentForm($this->comment, array('community_topic_id' => $this->community_topic_id));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('community_topic_comment'));
      if ($this->form->isValid())
      {
        $community_topic_comment = $this->form->save();
//        $this->redirect('community/edit?id=' . $community_topic->getId());
        //$this->redirect('community/?id=' . $request->getParameter('community_id'));
        $this->redirect('community_topic/detail?id='.$this->community_topic_id);

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
    $this->community_topic = CommunityTopicPeer::retrieveByPk($this->community_topic_id);
    $this->comments = CommunityTopicCommentPeer::retrieveByCommunityTopicId($this->community_topic_id);
    $this->community_id = $this->community_topic->getCommunityId();

    foreach ($this->comments as $comment)
    {
      echo $comment->delete();
    }

    $this->community_topic->delete();
    $this->redirect('community/home?id='.$this->community_id);
  }
}
