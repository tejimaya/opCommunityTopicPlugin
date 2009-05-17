<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEventTable
 * 
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityEvent
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class PluginCommunityEventTable extends Doctrine_Table
{
  public function retrieveByCommunityId($communityId)
  {
    return $this->createQuery()
      ->where('community_id = ?', $communityId)
      ->execute();
  }

  public function getEvents($communityId, $limit = 5)
  {
    return $this->createQuery()
      ->where('community_id = ?', $communityId)
      ->limit($limit)
      ->orderBy('updated_at DESC')
      ->execute();
  }

  public function getCommunityEventListPager($communityId, $page = 1, $size = 20)
  {
    $q = $this->createQuery()
      ->where('community_id = ?', $communityId)
      ->orderBy('updated_at DESC');

    $pager = new sfDoctrinePager('CommunityEvent', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public function retrivesByMemberId($memberId, $limit = 5)
  {
    $communityIds = Doctrine::getTable('Community')->getIdsByMemberId($memberId);
    return $this->createQuery()
      ->whereIn('community_id', $communityIds)
      ->limit($limit)
      ->orderBy('updated_at DESC')
      ->execute();
  }

  public function getRecentlyEventListPager($memberId, $page = 1, $size = 50)
  {
    $communityIds = Doctrine::getTable('Community')->getIdsByMemberId($memberId);
    $q = $this->createQuery()
      ->whereIn('community_id', $communityIds)
      ->orderBy('updated_at DESC');

    $pager = new sfDoctrinePager('CommunityEvent', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public function getEventMemberListPager($eventId, $page = 1, $size = 20)
  {
    $q = Doctrine::getTable('Member')->createQuery()
      ->where('CommunityEventMember.community_event_id = ?', $eventId);

    $pager = new sfDoctrinePager('CommunityEventMember', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}
