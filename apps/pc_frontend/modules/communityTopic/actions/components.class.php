<?php

class communityTopicComponents extends sfComponents
{
  public function executeTopicCommentListBox()
  {
    $this->communityTopic = CommunityTopicPeer::retrivesByMemberId($this->getUser()->getMember()->getId(), $this->widget->getConfig('col'));
  }
}
