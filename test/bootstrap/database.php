<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

if (empty($_app))
{
  $_app = 'pc_backend';
}
$_env = 'test';

$configuration = ProjectConfiguration::getApplicationConfiguration($_app, $_env, true);
new sfDatabaseManager($configuration);

$task = new sfDoctrineBuildTask($configuration->getEventDispatcher(), new sfFormatter());
$task->setConfiguration($configuration);
$task->run(array(), array(
  'no-confirmation' => true,
  'db'              => true,
  'and-load'        => false,
  'application'     => $_app,
  'env'             => $_env,
));

$task = new sfDoctrineDataLoadTask($configuration->getEventDispatcher(), new sfFormatter());
$task->setConfiguration($configuration);
if (!sfContext::hasInstance())
{
  sfContext::createInstance($configuration);
}
$task->run(dirname(__FILE__).'/../fixtures');

$conn = Doctrine_Manager::getInstance()->getCurrentConnection();
$conn->clear();
