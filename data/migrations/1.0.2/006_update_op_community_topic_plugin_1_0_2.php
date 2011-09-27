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
    $import = Doctrine_Manager::connection()->import;
    $export = Doctrine_Manager::connection()->export;

    $tableList = array(
      'community_topic',
      'community_topic_comment',
      'community_event',
      'community_event_comment',
    );

    foreach ($tableList as $table)
    {
      $tableName = $table.'_image';
      $indexes = $import->listTableIndexes($tableName);
      if (!in_array('post_id_idx', $indexes))
      {
        $export->createIndex($tableName, 'post_id_idx', array(
          'fields' => array('post_id')
        ));

        $definition = array(
          'name'          => $tableName.'_post_id_'.$table.'_id',
          'local'         => 'post_id',
          'foreign'       => 'id',
          'foreignTable'  => $table,
          'onDelete'      => 'CASCADE'
        );
        $export->createForeignKey($tableName, $definition);
      }

      if (!in_array('file_id_idx', $indexes))
      {
        $export->createIndex($tableName, 'file_id_idx', array(
          'fields' => array('file_id')
        ));

        $definition = array(
          'name'          => $tableName.'_file_id_file_id',
          'local'         => 'file_id',
          'foreign'       => 'id',
          'foreignTable'  => 'file',
          'onDelete'      => 'CASCADE'
        );
        $export->createForeignKey($tableName, $definition);
      } 
    }
  }
}
