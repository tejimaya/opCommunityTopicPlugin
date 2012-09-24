<?php
use_helper('opCommunityTopic');
$data = op_api_community_topic_comment($comment);
$data['deletable'] = $comment->isDeletable($memberId);

return array(
  'status' => 'success',
  'data' => $data,
);
