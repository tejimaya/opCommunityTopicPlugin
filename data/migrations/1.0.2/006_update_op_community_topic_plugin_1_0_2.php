<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class update_op_community_topic_plugin_1_0_2 extends opMigration
{
  public function up()
  {
    $export = Doctrine_Manager::connection()->export;

    $tableList = array(
      'community_topic',
      'community_topic_comment',
      'community_event',
      'community_event_comment',
    );

    foreach ($tableList as $table)
    {
      $export->createIndex($table.'_image', 'post_id_idx', array(
        'fields' => array('post_id')
      ));

      $export->createIndex($table.'_image', 'file_id_idx', array(
        'fields' => array('file_id')
      ));

      $definition = array(
                  'name'          => $table.'_image_file_id_file_id',
                  'local'         => 'file_id',
                  'foreign'       => 'id',
                  'foreignTable'  => 'file',
                  'onDelete'      => 'CASCADE'
      );
      $export->createForeignKey($table.'_image', $definition);

      $definition = array(
                  'name'          => $table.'_image_post_id_'.$table.'_id',
                  'local'         => 'post_id',
                  'foreign'       => 'id',
                  'foreignTable'  => $table,
                  'onDelete'      => 'CASCADE'
      );
      $export->createForeignKey($table.'_image', $definition);
    }
  }
}
