<?php

use_helper('opCommunityTopic');

$data = array();

if (count($topics))
{
  foreach ($topics as $topic)
  {
    $_topic = op_api_community_topic($topic);
    $comments = $topic->getCommunityTopicComment();
    $latest_comment = '';
    if(count($comments))
    {
      $latest_comment = op_api_community_topic_comment($comments->getLast());
    }
    $_topic['latest_comment'] = $latest_comment;
  
    $data[] = $_topic;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
  'next' => $next,
);
