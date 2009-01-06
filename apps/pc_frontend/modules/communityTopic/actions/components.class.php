<?php

class communityTopicComponents extends sfComponents
{
  public function executeCommunityTopicList()
  {
    $publicFlag = CommunityConfigPeer::retrieveByNameAndCommunityId('public_flag', $this->community->getId());
    $isBelong = $this->community->isPrivilegeBelong($this->getUser()->getMemberId());
    $this->hasPermission = true;

    if ($publicFlag && !$isBelong && $publicFlag->getValue() !== 'public')
    {
      $this->hasPermission = true;
      return sfView::SUCCESS;
    }

    $this->communityTopics = CommunityTopicPeer::getTopics($this->community->getId());
  }

  public function executeTopicCommentListBox()
  {
    $this->communityTopic = CommunityTopicPeer::retrivesByMemberId($this->getUser()->getMember()->getId(), $this->widget->getConfig('col'));
  }
}
