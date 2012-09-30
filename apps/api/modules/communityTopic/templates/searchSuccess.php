<?php

use_helper('opCommunityTopic');

$data = array();

if (count($topics))
{
  foreach ($topics as $topic)
  {
    $data[] = op_api_community_topic($topic);
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
