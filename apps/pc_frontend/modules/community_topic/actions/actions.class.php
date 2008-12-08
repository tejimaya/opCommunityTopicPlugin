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
    $this->id = $this->getRequestParameter('id');

//    $this->isCommunityMember = CommunityMemberPeer::isMember($this->getUser()->getMemberId(), $this->id);
//    $this->isAdmin = CommunityMemberPeer::isAdmin($this->getUser()->getMemberId(), $this->id);
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
    if ($this->id && !$this->isEditCommunity)
    {
      $this->forward('default', 'secure');
    }
*/

    $this->community_topic = CommunityTopicPeer::retrieveByPk($this->id);
    $this->form = new CommunityTopicForm($this->community_topic, array('community_id' => $request->getParameter('community_id')));

    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('community_topic'));
      if ($this->form->isValid())
      {
        $community_topic = $this->form->save();
//        $this->redirect('community/edit?id=' . $community_topic->getId());
        //$this->redirect('community/?id=' . $request->getParameter('community_id'));
        $this->redirect('community/list');

      }
    }

/*
    if (!$this->community_topic) {
      sfConfig::set('sf_navi_type', 'default');
    }
*/
  //  return $result;
  }
}
