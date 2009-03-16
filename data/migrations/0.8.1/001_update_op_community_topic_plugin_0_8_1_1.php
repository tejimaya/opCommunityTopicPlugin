<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class update_op_community_topic_plugin_0_8_1_1 extends opMigration
{
  public function up()
  {
    $conn = Doctrine_Manager::connection();
    $export = $conn->export;

    $export->alterTable('community_topic_comment', 
      array('remove' => array(
        'updated_at' => array()
      )
    ));
    $export->alterTable('community_topic', 
      array('add' => array(
        'topic_updated_at' => array(
          'type'    => 'timestamp',
          'notnull' => false
        )
      )
    ));

    $export->alterTable('community_topic_comment', array(
      'change' => array(
        'member_id' => array(
          'definition' => array(
            'type' => 'integer',
            'notnull' => false
          )
        )
      )
    ));
    $export->alterTable('community_topic', array(
      'change' => array(
        'member_id' => array(
          'definition' => array(
            'type' => 'integer',
            'notnull' => false
          )
        )
      )
    ));

    $export->dropForeignKey('community_topic_comment', 'community_topic_comment_FK_2');
    $export->dropForeignKey('community_topic', 'community_topic_FK_2');

    $export->createForeignKey('community_topic_comment', array(
      'name'         => 'community_topic_comment_FK_2',
      'local'        => 'member_id',
      'foreign'      => 'id',
      'foreignTable' => 'member',
      'onDelete'     => 'SET NULL'
    ));
    $export->createForeignKey('community_topic', array(
      'name'         => 'community_topic_FK_2',
      'local'        => 'member_id',
      'foreign'      => 'id',
      'foreignTable' => 'member',
      'onDelete'     => 'SET NULL'
    ));

    $communityTopics = CommunityTopicPeer::doSelect(new Criteria());
    foreach ($communityTopics as $communityTopic)
    {
      $communityTopic->setTopicUpdatedAt($communityTopic->getUpdatedAt());
      $communityTopic->save();
    }
  }

  public function down()
  {
    $conn = Doctrine_Manager::connection();
    $export = $conn->export;

    $export->alterTable('community_topic_comment', 
      array('add' => array(
        'updated_at' => array(
          'type'    => 'timestamp',
          'notnull' => false
        )
      )
    ));
    $export->alterTable('community_topic', 
      array('remove' => array(
        'topic_updated_at' => array()
      )
    ));

    $export->alterTable('community_topic_comment', array(
      'change' => array(
        'member_id' => array(
          'definition' => array(
            'type' => 'integer',
            'notnull' => true
          ))
      )
    ));
    $export->alterTable('community_topic', array(
      'change' => array(
        'member_id' => array(
          'definition' => array(
            'type' => 'integer',
            'notnull' => true
          ))
      )
    ));

    $export->dropForeignKey('community_topic_comment', 'community_topic_comment_FK_2');
    $export->dropForeignKey('community_topic', 'community_topic_FK_2');

    $export->createForeignKey('community_topic_comment', array(
      'name'         => 'community_topic_comment_FK_2',
      'local'        => 'member_id',
      'foreign'      => 'id',
      'foreignTable' => 'member',
    ));
    $export->createForeignKey('community_topic', array(
      'name'         => 'community_topic_FK_2',
      'local'        => 'member_id',
      'foreign'      => 'id',
      'foreignTable' => 'member',
    ));

    $communityTopicComments = CommunityTopicCommentPeer::doSelect(new Criteria());
    foreach ($communityTopicComments as $communityTopicComment)
    {
      $communityTopicComment->setUpdatedAt($communityTopic->getCreatedAt());
      $communityTopicComment->save();
    }
  }
}
