<?php

use_helper('opCommunityEvent', 'opCommunityTopic');

$data = array();

if (count($events))
{
  foreach ($events as $event)
  {
    $_event = op_api_community_event($event);
    $_event['editable'] = $event->isEditable($memberId);
    $_event['images'] = array('');
    $images = $event->getImages();
    if(count($images))
    {
      foreach($images as $image)
      {
        $_event['images'][] = op_api_topic_image($image);
      }
    }
    $data[] = $_event;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
