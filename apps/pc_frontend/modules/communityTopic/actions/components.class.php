<?php

class communityTopicComponents extends sfComponents
{
  public function executeTopicCommentListBox()
  {
    $c = new Criteria();
    $communityIds = CommunityPeer::getIdsByMemberId($this->getUser()->getMember()->getId());
    $c->add(CommunityTopicPeer::COMMUNITY_ID, $communityIds, Criteria::IN);
    $c->addDescendingOrderByColumn(CommunityTopicPeer::UPDATED_AT);
    $this->communityTopic = CommunityTopicPeer::doSelect($c);
  }
}
