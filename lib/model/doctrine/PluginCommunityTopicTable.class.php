<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopicTable
 *
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityTopicComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
class PluginCommunityTopicTable extends Doctrine_Table
{
  public function retrieveByCommunityId($communityId)
  {
    return $this->createQuery()
      ->where('community_id = ?', $communityId)
      ->execute();
  }

  public function getTopics($communityId, $limit = 5)
  {
    return $this->createQuery()
      ->where('community_id = ?', $communityId)
      ->limit($limit)
      ->orderBy('updated_at DESC')
      ->execute();
  }

  public function getCommunityTopicListPager($communityId, $page = 1, $size = 20)
  {
    $q = $this->createQuery()
      ->where('community_id = ?', $communityId)
      ->orderBy('updated_at DESC');
    $pager = new sfDoctrinePager('CommunityTopic', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public function retrivesByMemberId($memberId, $limit = 5)
  {
    $communityIds = Doctrine::getTable('Community')->getIdsByMemberId($memberId);
    if (!$communityIds && version_compare(OPENPNE_VERSION, '3.5.2-dev', '<'))
    {
      $communityIds[] = '0';
    }

    return $this->createQuery()
      ->whereIn('community_id', $communityIds)
      ->limit($limit)
      ->orderBy('updated_at DESC')
      ->execute();
  }

  public function getRecentlyTopicListPager($memberId, $page = 1, $size = 50)
  {
    $communityIds = Doctrine::getTable('Community')->getIdsByMemberId($memberId);
    if (!$communityIds && version_compare(OPENPNE_VERSION, '3.5.2-dev', '<'))
    {
      $communityIds[] = '0';
    }

    $q = $this->createQuery()
      ->whereIn('community_id', $communityIds)
      ->orderBy('updated_at DESC');

    $pager = new sfDoctrinePager('CommunityTopic', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }

  public function getSearchQuery($communityId = null, $target = null, $keyword = null)
  {
    $q = $this->createQuery();

    if ('all' !== $target && $communityId)
    {
      $q->where('community_id = ?', $communityId);
    }

    if (!is_null($keyword))
    {
      $values = preg_split('/[\s　]+/u', $keyword);
      foreach ($values as $value)
      {
        $q->andWhere('(name LIKE ? OR body LIKE ?)', array('%'.$value.'%', '%'.$value.'%'));
      }
    }

    $q->andWhereIn('community_id', opCommunityTopicToolkit::getPublicCommunityIdList())
      ->orderBy('updated_at DESC');

    return $q;
  }

  public function getResultListPager(Doctrine_Query $query, $page = 1, $size = 20)
  {
    $pager = new sfDoctrinePager('CommunityTopic', $size);
    $pager->setQuery($query);
    $pager->setPage($page);
    $pager->init();

    return $pager;
  }
}
