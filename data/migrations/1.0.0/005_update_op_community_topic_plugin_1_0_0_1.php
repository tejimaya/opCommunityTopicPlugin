<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class update_op_community_topic_plugin_1_0_0_1 extends opMigration
{
  public function up()
  {
    $conn = Doctrine_Manager::connection();

    $conn->export->createTable('community_topic_image',
      array(
        'id' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
        'post_id' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
        'file_id' => array('type' => 'integer', 'notnull' => '0', 'length' => '4'),
        'number' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
    ));
    $conn->export->createIndex('community_topic_image', 'id_number', array(
      'fields' => array('id', 'number'),
      'type'   => 'unique',
    ));

    $conn->export->createTable('community_topic_comment_image',
      array(
        'id' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
        'post_id' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
        'file_id' => array('type' => 'integer', 'notnull' => '0', 'length' => '4'),
        'number' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
    ));
    $conn->export->createIndex('community_topic_comment_image', 'id_number', array(
      'fields' => array('id', 'number'),
      'type'   => 'unique',
    ));

    $conn->export->createTable('community_event_image',
      array(
        'id' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
        'post_id' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
        'file_id' => array('type' => 'integer', 'notnull' => '0', 'length' => '4'),
        'number' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
    ));
    $conn->export->createIndex('community_event_image', 'id_number', array(
      'fields' => array('id', 'number'),
      'type'   => 'unique',
    ));

    $conn->export->createTable('community_event_comment_image',
      array(
        'id' => array('type' => 'integer', 'primary' => true, 'autoincrement' => true),
        'post_id' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
        'file_id' => array('type' => 'integer', 'notnull' => '0', 'length' => '4'),
        'number' => array('type' => 'integer', 'notnull' => '1', 'length' => '4'),
    ));
    $conn->export->createIndex('community_event_comment_image', 'id_number', array(
      'fields' => array('id', 'number'),
      'type'   => 'unique',
    ));
  }

  public function down()
  {
    $this->dropTable('community_topic_image');
    $this->dropTable('community_topic_comment_image');
    $this->dropTable('community_event_image');
    $this->dropTable('community_event_comment_image');
  }
}
