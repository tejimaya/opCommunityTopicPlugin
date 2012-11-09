<?php

use_helper('Date', 'opCommunityEvent', 'opCommunityTopic');

$data = array();

if (isset($events[0]['id']))
{
  foreach ($events as $event)
  {
    $event->setOpenDate(op_format_date($event->getOpenDate(), 'D'));
    $event->setApplicationDeadline(op_format_date($event->getApplicationDeadline(), 'D'));
    $_event = op_api_community_event($event);
    $_event['images'] = array('');
    $images = $event->getImages();
    if(count($images))
    {
      foreach($images as $image)
      {
        $_event['images'][] = op_api_topic_image($image);
      }
    }
    $_event['is_event_member'] = $event->isEventMember($memberId);
    $data[] = $_event;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
