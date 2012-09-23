<?php
use_helper('opCommunityTopic');
$data = op_api_community_topic_comment($comment);

return array(
  'status' => 'success',
  'data' => $data,
);
