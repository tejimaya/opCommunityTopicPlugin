<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopicCommentTable
 *
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityEventComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class PluginCommunityTopicCommentTable extends Doctrine_Table
{
  public function retrieveByCommunityTopicId($communityTopicId)
  {
    return $this->createQuery()
      ->where('community_topic_id = ?', $communityTopicId)
      ->execute();
  }

  public function getCommunityTopicCommentListPager($communityTopicId, $page = 1, $size = 20, $order = 'DESC')
  {
    $q = $this->createQuery()
      ->where('community_topic_id = ?', $communityTopicId);

    $pager = new sfReversibleDoctrinePager('CommunityTopicComment', $size);
    $pager->setQuery($q);
    $pager->setPage($page);
    $pager->setSqlOrderColumn('id');
    $pager->setSqlOrder($order);
    $pager->setListOrder(sfReversibleDoctrinePager::ASC);
    $pager->setMaxPerPage($size);
    $pager->init();

    return $pager;
  }

  public function getMaxNumber($communityTopicId)
  {
    $result = $this->createQuery()
      ->select('number')
      ->where('community_topic_id = ?', $communityTopicId)
      ->orderBy('number DESC')
      ->fetchOne();

    if ($result)
    {
      return (int)$result->getNumber();
    }

    return 0;
  }
}
