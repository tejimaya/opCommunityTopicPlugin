<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class update_op_community_topic_plugin_0_8_1_3 extends opMigration
{
  public function up()
  {
    $this->createTable('community_event', array(
      'id' => array(
        'type'          => 'integer',
        'length'        => 4,
        'notnull'       => true,
        'autoincrement' => true,
      ),

      'community_id' => array(
        'type'    => 'integer',
        'length'  => 4,
        'notnull' => true,
      ),

      'member_id' => array(
        'type'    => 'integer',
        'length'  => 4,
        'default' => null,
      ),

      'name' => array(
        'type'    => 'string',
        'notnull' => true,
      ),

      'body' => array(
        'type'    => 'string',
        'notnull' => true,
      ),

      'created_at' => array(
        'type'    => 'timestamp',
        'default' => null,
      ),

      'updated_at' => array(
        'type'    => 'timestamp',
        'default' => null,
      ),

      'event_updated_at' => array(
        'type'    => 'timestamp',
        'default' => null,
      ),

      'open_date' => array(
        'type'    => 'timestamp',
        'notnull' => true,
      ),

      'open_date_comment' => array(
        'type'    => 'string',
        'notnull' => true,
      ),

      'area' => array(
        'type'    => 'string',
        'notnull' => true,
      ),

      'application_deadline' => array(
        'type'    => 'timestamp',
        'default' => null,
      ),

      'capacity' => array(
        'type'    => 'integer',
        'length'  => 4,
        'default' => null,
      ),
    ), array(
      'primary'     => array('id'),
      'foreignKeys' => array(
        array(
          'name'         => 'community_event_FK_1',
          'local'        => 'community_id',
          'foreign'      => 'id',
          'foreignTable' => 'community',
          'onDelete'     => 'CASCADE',
        ),
        array(
          'name'         => 'community_event_FK_2',
          'local'        => 'member_id',
          'foreign'      => 'id',
          'foreignTable' => 'member',
          'onDelete'     => 'SET NULL',
        ),
      ),
    ));

    $this->createTable('community_event_comment', array(
      'id' => array(
        'type'          => 'integer',
        'length'        => 4,
        'notnull'       => true,
        'autoincrement' => true,
      ),

      'community_event_id' => array(
        'type'    => 'integer',
        'length'  => 4,
        'notnull' => true,
      ),

      'member_id' => array(
        'type'    => 'integer',
        'length'  => 4,
        'default' => null,
      ),

      'number' => array(
        'type'    => 'integer',
        'length'  => 4,
        'default' => 0,
        'notnull' => true,
      ),

      'body' => array(
        'type'    => 'string',
        'notnull' => true,
      ),

      'created_at' => array(
        'type'    => 'timestamp',
        'default' => null,
      ),
    ), array(
      'primary'     => array('id'),
      'foreignKeys' => array(
        array(
          'name'         => 'community_event_comment_FK_1',
          'local'        => 'community_event_id',
          'foreign'      => 'id',
          'foreignTable' => 'community',
          'onDelete'     => 'CASCADE',
        ),
        array(
          'name'         => 'community_event_comment_FK_2',
          'local'        => 'member_id',
          'foreign'      => 'id',
          'foreignTable' => 'member',
          'onDelete'     => 'CASCADE',
        ),
      ),
    ));

    $this->createTable('community_event_member', array(
      'id' => array(
        'type'          => 'integer',
        'length'        => 4,
        'notnull'       => true,
        'autoincrement' => true,
      ),

      'community_event_id' => array(
        'type'    => 'integer',
        'length'  => 4,
        'notnull' => true,
      ),

      'member_id' => array(
        'type'    => 'integer',
        'length'  => 4,
        'notnull' => true,
      ),
    ), array(
      'primary'     => array('id'),
      'foreignKeys' => array(
        array(
          'name'         => 'community_event_member_FK_1',
          'local'        => 'community_event_id',
          'foreign'      => 'id',
          'foreignTable' => 'community',
          'onDelete'     => 'CASCADE',
        ),
        array(
          'name'         => 'community_event_member_FK_2',
          'local'        => 'member_id',
          'foreign'      => 'id',
          'foreignTable' => 'member',
          'onDelete'     => 'CASCADE',
        ),
      ),
    ));
  }

  public function down()
  {
    $this->dropTable('community_event_comment');
    $this->dropTable('community_event_member');
    $this->dropTable('community_event');
  }
}
