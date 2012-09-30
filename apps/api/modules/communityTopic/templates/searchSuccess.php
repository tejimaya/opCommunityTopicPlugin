<?php

use_helper('opCommunityTopic');

$data = array();

if (count($topics))
{
  foreach ($topics as $topic)
  {
    $_topic = op_api_community_topic($topic);
    $_topic['editable'] = $topic->isEditable($memberId);
    $images = $topic->getImages();
    if(count($images))
    {
      foreach($images as $image)
      {
        $_topic['images'][] = op_api_topic_image($image);
      }
    }
    $data[] = $_topic;
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
