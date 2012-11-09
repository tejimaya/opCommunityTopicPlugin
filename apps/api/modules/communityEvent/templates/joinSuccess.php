<?php

use_helper('opCommunityEvent');

$data = array();
if (!is_null($events))
{
  foreach ($events as $event)
  {
    $data[] = op_api_community_event($event);
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
