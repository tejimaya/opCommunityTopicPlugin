<?php

class CommunityTopicCommentPeer extends BaseCommunityTopicCommentPeer
{
  public static function retrieveByCommunityTopicId($community_id) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_TOPIC_ID, $community_id);
    $list = self::doSelect($c);
    return $list;
  }
}
