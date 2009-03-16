<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class update_op_community_topic_plugin_0_8_1_2 extends opMigration
{
  public function up()
  {
    $conn = Doctrine_Manager::connection();
    $export = $conn->export;

    $export->alterTable('community_topic_comment', array(
      'add' => array(
        'number' => array(
          'type'    => 'integer',
          'default' => 0,
          'notnull' => true
        )
      ) 
    ));

    $communityTopics = CommunityTopicPeer::doSelect(new Criteria());
    foreach ($communityTopics as $communityTopic)
    {
      $criteria = new Criteria();
      $criteria->add(CommunityTopicCommentPeer::COMMUNITY_TOPIC_ID, $communityTopic->getId());
      $criteria->addAscendingOrderByColumn(CommunityTopicCommentPeer::CREATED_AT);
      $communityTopicComments = CommunityTopicCommentPeer::doSelect($criteria);

      $i = 0;
      foreach ($communityTopicComments as $communityTopicComment)
      {
        $i++;
        $communityTopicComment->setNumber($i);
        $communityTopicComment->save();
      }
    }

    $export->alterTable('community_topic_comment', array(
      'change' => array(
        'number' => array(
          'definition' => array(
            'type'    => 'integer',
            'notnull' => true
          )
        )
      ) 
    ));   
  }

  public function down()
  {
    $conn = Doctrine_Manager::connection();
    $export = $conn->export;

    $export->alterTable('community_topic_comment',
      array('remove' => array(
        'number' => array()
      )
    ));
  }
}
