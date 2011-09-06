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

    $rs = Doctrine::getTable('CommunityConfig')->createQuery()
      ->select('id, community_id')
      ->where('name = ?', array('public_flag'))
      ->andWhere('value = ?', array('public'))
      ->execute(array(), Doctrine::HYDRATE_NONE);

    foreach ($rs as $r)
    {
      $result[] = $r[1];
    }

    return $result;
  }
}
