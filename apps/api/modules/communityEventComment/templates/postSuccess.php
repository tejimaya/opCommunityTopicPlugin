<?php
use_helper('opCommunityEvent');
$data = op_api_community_event_comment($comment);
$data['deletable'] = $comment->isDeletable($memberId);

return array(
  'status' => 'success',
  'data' => $data,
);
