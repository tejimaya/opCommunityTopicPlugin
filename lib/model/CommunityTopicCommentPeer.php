<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

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

  public static function getMaxNumber($communityTopicId)
  {
    $criteria = new Criteria();
    $criteria->clearSelectColumns()->addSelectColumn(self::NUMBER);
    $criteria->add(self::COMMUNITY_TOPIC_ID, $communityTopicId);
    $criteria->addDescendingOrderByColumn(self::NUMBER);
    $criteria->setLimit(1);

    $stmt = self::doSelectStmt($criteria);
    $row = $stmt->fetch(PDO::FETCH_NUM);


    return (int)$row[0];
  }
}
