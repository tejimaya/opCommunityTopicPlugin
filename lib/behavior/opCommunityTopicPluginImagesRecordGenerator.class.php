<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginImagesRecordGenerator
 *
 * @package    opCommunityTopicPlugin
 * @subpackage behavior
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicPluginImagesRecordGenerator extends Doctrine_Record_Generator
{
  protected $_options = array(
    'className' => '%CLASS%Image',
    'tableName' => '%TABLE%_image',
    'generateFiles' => false,
    'table' => false,
    'pluginTable' => false,
    'children' => array(),
    'options' => array(),
    'cascadeDelete' => true,
    'appLevelDelete'=> false,
    'builderOptions' => array(
      'baseClassName' => 'opDoctrineRecord',
    ),
  );

  public function __construct($options)
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }

  public function buildRelation()
  {
    $this->buildForeignRelation('Images');
    $this->buildLocalRelation();
  }

  public function setTableDefinition()
  {
    $this->hasColumn('id', 'integer', 4, array(
      'type' => 'integer',
      'primary'  => true, 
      'autoincrement' =>  true,
    ));

    $this->hasColumn('post_id', 'integer', 4, array(
      'type' => 'integer',
      'notnull' => true,
      'length' => 4,
    ));

    $this->hasColumn('file_id', 'integer', 4, array(
      'type' => 'integer',
      'notnull' => false,
      'length' => 4,
    ));

    $this->hasColumn('number', 'integer', 4, array(
      'type' => 'integer',
      'notnull' => true,
      'length' => 4,
    ));

    $this->index('id_number', array(
      'fields' => 
       array(
         0 => 'id',
         1 => 'number',
       ),
       'type' => 'unique',
     ));
    $this->option('charset', 'utf8');
  }

  public function setUp()
  {
    parent::setUp();

    $this->_options['table']->hasMany($this->_options['table']->getComponentName().'Image as Images', array(
      'local'   => 'id',
      'foreign' => 'post_id',
    ));

    $this->hasOne($this->_options['table']->getComponentName(), array(
      'local' => 'post_id',
      'foreign' => 'id',
      'onDelete' => 'cascade',
    ));

    $this->hasOne('File', array(
      'local' => 'file_id',
      'foreign' => 'id',
      'onDelete' => 'cascade',
    ));
    $this->addListener(new opCommunityTopicPluginImagesListener($this->_options));
  }
}
