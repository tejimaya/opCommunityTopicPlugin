<?php

use_helper('opCommunityTopic');

$data = array();

if (isset($topic))
{
  $data = op_api_community_topic($topic);
  $data['editable'] = $topic->isEditable($memberId);
  $images = $topic->getImages();
  foreach($images as $image){
    $data['images'][] = op_api_topic_image($image);
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
