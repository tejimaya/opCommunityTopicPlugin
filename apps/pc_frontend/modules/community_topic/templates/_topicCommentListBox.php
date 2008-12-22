<?php
$option = array(
  'title' => 'コミュニティ最新書き込み',
  'col' => $sf_data->getRaw('widget')->getConfig('num'),
);
$list = array();
foreach ($communityTopic as $topic) {
  $topicId = $topic->getId();
  $topicName = $topic->getName();
  $communityName = $topic->getCommunity()->getName();
  $countComment = $topic->countCommunityTopicComments();
  $updateTopic = $topic->getUpdatedAt();

  $list[$updateTopic] = link_to($topicName.' ('.$countComment.')', 'community_topic/detail?id='.$topicId).' ('.$communityName.')';
}

include_list_box('recentCommunityTopicComment', $list, $option);
