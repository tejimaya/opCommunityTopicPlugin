<?php

/**
 * comment actions.
 *
 * @package    OpenPNE
 * @subpackage comment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class commentActions extends sfActions
{
  public function preExecute()
  {
    $this->community_topic_id = $this->getRequestParameter('id');
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
  }

 /**
  * Executes delete action
  *
  * @param sfRequest $request A request object
  */
  public function executeDelete($request)
  {
    $this->community_topic = CommunityTopicPeer::retrieveByPk($this->community_topic_id);
    $this->comment = CommunityTopicCommentPeer::retrieveByPk($request->getParameter('comment_id'));

    $this->comment->delete();
    $this->redirect('community_topic/detail?id='.$this->community_topic_id);

  }
}
