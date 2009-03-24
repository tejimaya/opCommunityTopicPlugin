<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class CommunityEventPeer extends BaseCommunityEventPeer
{
  public static function retrieveByCommunityId($communityId)
  {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $communityId);
    $list = self::doSelect($c);
    return $list;
  }

  public static function getEvents($communityId, $limit = 5)
  {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $communityId);
    $c->setLimit($limit);
    $c->addDescendingOrderByColumn(self::UPDATED_AT);
    $list = self::doSelect($c);
    return $list;
  }

  public static function getCommunityEventListPager($communityId, $page = 1, $size = 20) {
    $c = new Criteria();
    $c->add(self::COMMUNITY_ID, $communityId);
    $c->addDescendingOrderByColumn(self::UPDATED_AT);

    $pager = new sfPropelPager('CommunityEvent', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public static function retrivesByMemberId($memberId, $limit = 5)
  {
    $c = new Criteria();
    $communityIds = CommunityPeer::getIdsByMemberId($memberId);
    $c->add(CommunityEventPeer::COMMUNITY_ID, $communityIds, Criteria::IN);
    $c->setLimit($limit);
    $c->addDescendingOrderByColumn(CommunityEventPeer::UPDATED_AT);
    return CommunityEventPeer::doSelect($c);
  }

  public static function getRecentlyEventListPager($memberId, $page = 1, $size = 50)
  {
    $c = new Criteria();
    $communityIds = CommunityPeer::getIdsByMemberId($memberId);
    $c->add(CommunityEventPeer::COMMUNITY_ID, $communityIds, Criteria::IN);
    $c->addDescendingOrderByColumn(CommunityEventPeer::UPDATED_AT);
    
    $pager = new sfPropelPager('CommunityEvent', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public static function getEventMemberListPager($eventId, $page = 1, $size = 20)
  {
    $c = new Criteria();
    $c->add(CommunityEventMemberPeer::COMMUNITY_EVENT_ID, $eventId);
    $c->addJoin(MemberPeer::ID, CommunityEventMemberPeer::MEMBER_ID);

    $pager = new sfPropelPager('Member', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}
