<?php

class CommunityTopicCommentPeer extends BaseCommunityTopicCommentPeer
{
  public static function retrieveByCommunityTopicId($community_id) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_TOPIC_ID, $community_id);
    $list = self::doSelect($c);
    return $list;
  }

  public static function getCommunityTopicCommentListPager($communityTopicId, $page = 1, $size = 20) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_TOPIC_ID, $communityTopicId);

    $pager = new sfPropelPager('CommunityTopicComment', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}
