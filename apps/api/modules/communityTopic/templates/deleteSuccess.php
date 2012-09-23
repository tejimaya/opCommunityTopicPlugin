<?php
use_helper('opCommunityTopic');
$data = op_api_community_topic($topic);

return array(
  'status' => 'success',
  'data' => $data,
);
