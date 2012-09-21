<?php

use_helper('opCommunityTopic');

$data = array();

if (count($topics))
{
  foreach ($topics as $topic)
  {
    $_topic = op_api_community_topic($topic);
    $data[] = $_topic;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
  'next' => $next,
);
