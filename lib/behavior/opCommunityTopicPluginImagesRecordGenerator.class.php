<?php

class opCommunityTopicPluginImagesRecordGenerator extends Doctrine_Record_Generator
{

  public function __construct($options)
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }

  public function buildRelation()
  {
    $this->buildForeignRelation('Images');
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
      'notnull' => true,
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

  public function initOptions()
  {
    $builderOptions  = array(
      'suffix' =>  '.class.php',
      'baseClassesDirectory' => 'base',
      'generateBaseClasses' => true,
      'generateTableClasses' => true,
      'baseClassName' => 'opDoctrineRecord',
    );
    $this->setOption('className', '%CLASS%Image');
    $this->setOption('tableName', '%TABLE%_image');
    $this->setOption('generateFiles', true);
    $this->setOption('generatePath', sfConfig::get('sf_lib_dir') . '/model/doctrine/opCommunityTopicPlugin');
    $this->setOption('children', array());
    $this->setOption('options', array());
    $this->setOption('cascadeDelete', true);
    $this->setOption('appLevelDelete', false);
    $this->setOption('builderOptions', $builderOptions);
  }

  public function generateClassFromTable(Doctrine_Table $table)
  {
    $definition = array();
    $definition['columns'] = $table->getColumns();
    $definition['tableName'] = $table->getTableName();
    $definition['actAs'] = $table->getTemplates();
    $definition['generate_once'] = true;
    $generatedclass = $this->generateClass($definition);
    Doctrine::loadModels(sfConfig::get('sf_lib_dir') . '/model/doctrine/opCommunityTopicPlugin/base/');
    return $generatedclass;
  }
}
