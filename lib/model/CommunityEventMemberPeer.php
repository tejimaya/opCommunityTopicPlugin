<?php

class CommunityEventMemberPeer extends BaseCommunityEventMemberPeer
{
  public static function retrieveByEventIdAndMemberId($eventId, $memberId)
  {
    $c = new Criteria();
    $c->add(self::COMMUNITY_EVENT_ID, $eventId);
    $c->add(self::MEMBER_ID, $memberId);
    return self::doSelectOne($c);
  }
}
