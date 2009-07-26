<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEventMemberTable
 *
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityEventMember
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class PluginCommunityEventMemberTable extends Doctrine_Table
{
  public function retrieveByEventIdAndMemberId($eventId, $memberId)
  {
    return $this->createQuery()
      ->where('community_event_id = ?', $eventId)
      ->andWhere('member_id = ?', $memberId)
      ->fetchOne();
  }
}
