<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

new sfDatabaseManager(ProjectConfiguration::getApplicationConfiguration('pc_frontend', 'test', true));

// execute propel:insert-sql task
$task = new sfPropelInsertSqlTask(new sfEventDispatcher(), new sfAnsiColorFormatter());
$task->run(array(), array('no-confirmation'));

$loader = new sfPropelData();
$loader->loadData(dirname(__FILE__).'/../fixtures');
