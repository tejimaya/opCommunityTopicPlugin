<?php
use_helper('opCommunityTopic');

$data = array('comments'=>array());

if (count($comments))
{
  foreach ($comments as $comment)
  {
    $_comment =  op_api_community_topic_comment($comment);;
    $_comment['deletable'] = $comment->isDeletable($memberId);
    $images = $comment->getImages();
    if (count($images) > 0)
    {
      foreach($images as $image){
        $_comment['images'][] = op_api_topic_image($image);
      }
    }
    $data['comments'][] = $_comment;
  }
  $data['comments'] = array_reverse($data['comments']);
}

return array(
  'status' => 'success',
  'data' => $data,
  'next' => $next,
);
