<?php

class CommunityEventCommentPeer extends BaseCommunityEventCommentPeer
{
  public static function retrieveByCommunityEventId($community_id)
  {
    $c = new Criteria();
    $c->add(self::COMMUNITY_EVENT_ID, $community_id);
    $list = self::doSelect($c);
    return $list;
  }

  public static function getCommunityEventCommentListPager($communityEventId, $page = 1, $size = 20, $order = 'DESC')
  {
    $c = new Criteria();
    $c->add(self::COMMUNITY_EVENT_ID, $communityEventId);
    
    $pager = new sfReversiblePropelPager('CommunityEventComment', $size);
    $pager->setCriteria($c);
    $pager->setPage($page);
    $pager->setSqlOrderColumn(CommunityEventCommentPeer::ID);
    $pager->setSqlOrder($order);
    $pager->setListOrder(Criteria::ASC);
    $pager->setMaxPerPage($size);
    $pager->init();

    return $pager;
  }

  public static function getMaxNumber($communityEventId)
  {
    $criteria = new Criteria();
    $criteria->clearSelectColumns()->addSelectColumn(self::NUMBER);
    $criteria->add(self::COMMUNITY_EVENT_ID, $communityEventId);
    $criteria->addDescendingOrderByColumn(self::NUMBER);
    $criteria->setLimit(1);

    $stmt = self::doSelectStmt($criteria);
    $row = $stmt->fetch(PDO::FETCH_NUM);


    return (int)$row[0];
  }
}
