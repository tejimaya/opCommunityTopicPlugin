<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicToolkit
 *
 * @package    opCommunityTopicPlugin
 * @subpackage util
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicToolkit
{
  static public function getPublicCommunityIdList()
  {
    $result = array();

    $table = Doctrine::getTable('CommunityConfig');

    $sql = 'SELECT community_id FROM '.$table->getTableName()
         . ' WHERE name = "public_flag"'
         . ' AND value IN ("public", "open")';

    $conn = $table->getConnection();
    $communityIds = $conn->fetchColumn($sql);

    return $communityIds;
  }
}
