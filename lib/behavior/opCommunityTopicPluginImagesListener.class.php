<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginImagesListener
 *
 * @package    opCommunityTopicPlugin
 * @subpackage behavior
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicPluginImagesListener extends Doctrine_Record_Listener
{
  public function preInsert(Doctrine_Event $event)
  {
    $this->setFileNamePrefix($event->getInvoker());
  }

  protected function setFileNamePrefix($invoker)
  {
    $prefix = 'ct' . '_' . $invoker->getId() . '_' . $invoker->getNumber() . '_';

    $file = $invoker->File;
    if ($file)
    {
      $file->setName($prefix.$file->name);
    }
  }

  public function postDelete(Doctrine_Event $event)
  {
    $invoker = $event->getInvoker();
    $invoker->File->FileBin->delete();
    $invoker->File->delete();
  }
}
