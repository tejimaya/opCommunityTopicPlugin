<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEventCommentTable
 *
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityEventComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class PluginCommunityEventCommentTable extends Doctrine_Table
{
  public function retrieveByCommunityEventId($communityEventId)
  {
    return $this->createQuery()
      ->where('community_event_id = ?', $communityEventId)
      ->execute();
  }

  public function getCommunityEventCommentListPager($communityEventId, $page = 1, $size = 20, $order = 'DESC')
  {
    $q = $this->createQuery()
      ->where('community_event_id = ?', $communityEventId);

    $pager = new sfReversibleDoctrinePager('CommunityEventComment', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->setSqlOrderColumn('id');
    $pager->setSqlOrder($order);
    $pager->setListOrder(sfReversibleDoctrinePager::ASC);
    $pager->setMaxPerPage($size);
    $pager->init();

    return $pager;
  }

  public function getMaxNumber($communityEventId)
  {
    $result = $this->createQuery()
      ->select('number')
      ->where('community_event_id = ?', $communityEventId)
      ->orderBy('number DESC')
      ->fetchOne();

    if ($result)
    {
      return (int)$result->getNumber();
    }

    return 0;
  }
}
