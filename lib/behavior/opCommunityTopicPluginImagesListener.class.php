<?php

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
    $file->setName($prefix.$file->name);
  }

  public function postDelete(Doctrine_Event $event)
  {
    $invoker = $event->getInvoker();
    $invoker->File->FileBin->delete();
    $invoker->File->delete();
  }
}
