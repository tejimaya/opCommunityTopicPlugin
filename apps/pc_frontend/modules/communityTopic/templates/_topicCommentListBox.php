<?php
$option = array(
  'title' => 'コミュニティ最新書き込み',
);
$list = array();
$displayNum = $sf_data->getRaw('widget')->getConfig('col');
foreach ($communityTopic as $key => $value)
{
  if ($key >= $displayNum)
  {
    break;
  }

  $topicId = $value->getId();
  $topicName = $value->getName();
  $communityName = $value->getCommunity()->getName();
  $countComment = $value->countCommunityTopicComments();
  $updateTopic = $value->getUpdatedAt();

  $list[$updateTopic] = link_to($topicName.' ('.$countComment.')', 'communityTopic/detail?id='.$topicId).' ('.$communityName.')';
}

include_list_box('recentCommunityTopicComment', $list, $option);
