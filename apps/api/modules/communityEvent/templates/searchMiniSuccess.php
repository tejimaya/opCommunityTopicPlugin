<?php

use_helper('opCommunityEvent');

$data = array();

if (count($events))
{
  foreach ($events as $event)
  {
    $_event = op_api_community_event_mini($event);
    $comments = $event->getCommunityEventComment();
    $_event['latest_comment'] = '';
    $_event['latest_comment_id'] = '';
    if(count($comments))
    {
      $latest_comment = op_api_community_event_comment($comments->getLast());
      $_event['latest_comment'] = $latest_comment['body'];
      $_event['latest_comment_id'] = $latest_comment['id'];
    }

    $data[] = $_event;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
