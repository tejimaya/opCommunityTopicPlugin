<?php

use_helper('opCommunityEvent');

$data = array();

if (isset($events[0]['id']))
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

    $_event['is_event_member'] = $event->isEventMember($memberId);
    $data[] = $_event;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
