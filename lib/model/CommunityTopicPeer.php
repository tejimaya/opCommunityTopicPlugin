<?php

class CommunityTopicPeer extends BaseCommunityTopicPeer
{
  public static function retrieveByCommunityId($community_id) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $community_id);
    $list = self::doSelect($c);
    return $list;
  }
}
