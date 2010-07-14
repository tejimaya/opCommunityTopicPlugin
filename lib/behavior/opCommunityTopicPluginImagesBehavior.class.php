<?php

class opCommunityTopicPluginImagesBehavior extends Doctrine_Template
{
  public function __construct(array $options = array())
  {
    parent::__construct($options);

    $this->_plugin = new opCommunityTopicPluginImagesRecordGenerator($this->getOptions());
  }

  public function setUp()
  {
    $this->_plugin->initialize($this->getTable());
  }
}
