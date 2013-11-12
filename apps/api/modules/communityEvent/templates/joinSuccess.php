<?php

use_helper('opCommunityEvent');

$data = array();

$_event = op_api_community_event($event);
$_event['is_event_member'] = $event->isEventMember($memberId);
$data[] = $_event;

return array(
  'status' => 'success',
  'data' => $data,
);
