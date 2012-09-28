<?php
use_helper('opCommunityTopic');
$data = op_api_community_topic($topic);
$data['editable'] = $topic->isEditable($memberId);
$data['images'] = array();

return array(
  'status' => 'success',
  'data'   => $data
);
