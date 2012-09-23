<?php
use_helper('opCommunityTopic');

$data = array('comments'=>array());

if (count($comments))
{
  foreach ($comments as $comment)
  {
    $_comment =  op_api_community_topic_comment($comment);;
    $_comment['deletable'] = $comment->isDeletable($memberId);
    $data['comments'][] = $_comment;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
