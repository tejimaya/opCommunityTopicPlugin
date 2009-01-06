<?php

class CommunityTopicPeer extends BaseCommunityTopicPeer
{
  public static function retrieveByCommunityId($communityId) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $communityId);
    $list = self::doSelect($c);
    return $list;
  }

  public static function getTopics($communityId, $limit = 5) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $communityId);
    $c->setLimit($limit);
    $c->addDescendingOrderByColumn(self::UPDATED_AT);
    $list = self::doSelect($c);
    return $list;
  }

  public static function getCommunityTopicListPager($communityId, $page = 1, $size = 20) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $communityId);
    $c->addDescendingOrderByColumn(self::UPDATED_AT);

    $pager = new sfPropelPager('CommunityTopic', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public static function retrivesByMemberId($memberId, $limit = 5)
  {
    $c = new Criteria();
    $communityIds = CommunityPeer::getIdsByMemberId($memberId);
    $c->add(CommunityTopicPeer::COMMUNITY_ID, $communityIds, Criteria::IN);
    $c->setLimit($limit);
    $c->addDescendingOrderByColumn(CommunityTopicPeer::UPDATED_AT);
    return CommunityTopicPeer::doSelect($c);
  }
}
