<?php
use_helper('opCommunityEvent');
$data = op_api_community_event($event);
$data['editable'] = $event->isEditable($memberId);
$data['images'] = array();

return array(
  'status' => 'success',
  'data'   => $data
);
