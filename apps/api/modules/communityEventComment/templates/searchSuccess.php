<?php
use_helper('opCommunityEvent');

$data = array();

if (isset($comments[0]['id']))
{
  foreach ($comments as $comment)
  {
    $_comment =  op_api_community_event_comment($comment);;
    $_comment['deletable'] = $comment->isDeletable($memberId);
    $images = $comment->getImages();
    if (count($images) > 0)
    {
      foreach($images as $image){
        $_comment['images'][] = op_api_event_image($image);
      }
    }
    $data[] = $_comment;
  }
  $data = array_reverse($data);
}

return array(
  'status' => 'success',
  'data' => $data,
);
