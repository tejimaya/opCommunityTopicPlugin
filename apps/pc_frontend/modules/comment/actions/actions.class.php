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
    $this->communityTopicId = $this->getRequestParameter('id');
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
    $this->communityTopic = CommunityTopicPeer::retrieveByPk($this->communityTopicId);
    $this->comment = CommunityTopicCommentPeer::retrieveByPk($request->getParameter('comment_id'));

    $this->comment->delete();
    $this->redirect('community_topic/detail?id='.$this->communityTopicId);

  }
}
