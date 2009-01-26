<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class opCommunityTopicPluginUpdate_0_5_to_0_6_dev_200901262342 extends opUpdate
{
  public function update()
  {
    $this->dropForeignKey('community_topic', 'community_topic_FK_1');
    $this->dropForeignKey('community_topic', 'community_topic_FK_2');

    $this->createForeignKey('community_topic', array(
      'name'         => 'community_topic_FK_1',
      'local'        => 'community_id',
      'foreign'      => 'id',
      'foreignTable' => 'community',
      'onDelete'     => 'CASCADE',
    ));

    $this->createForeignKey('community_topic', array(
      'name'         => 'community_topic_FK_2',
      'local'        => 'member_id',
      'foreign'      => 'id',
      'foreignTable' => 'member',
    ));

    $this->changeColumn('community_topic', 'name', 'string', array('notnull' => true));
    $this->addColumn('community_topic', 'body', 'string', array('notnull' => true));

    $this->dropForeignKey('community_topic_comment', 'community_topic_comment_FK_1');
    $this->dropForeignKey('community_topic_comment', 'community_topic_comment_FK_2');

    $this->createForeignKey('community_topic_comment', array(
      'name'         => 'community_topic_comment_FK_1',
      'local'        => 'community_topic_id',
      'foreign'      => 'id',
      'foreignTable' => 'community_topic',
      'onDelete'     => 'CASCADE',
    ));

    $this->createForeignKey('community_topic_comment', array(
      'name'         => 'community_topic_comment_FK_2',
      'local'        => 'member_id',
      'foreign'      => 'id',
      'foreignTable' => 'member',
    ));

    $this->changeColumn('community_topic_comment', 'body', 'string', array('notnull' => true));
  }
}
