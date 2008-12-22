<?php

class community_topicComponents extends sfComponents
{
  public function executeTopicCommentListBox()
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(CommunityTopicPeer::UPDATED_AT);
    $this->communityTopic = CommunityTopicPeer::doSelect($c);
  }
}
