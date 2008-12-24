<?php
$option = array(
  'title' => 'コミュニティ最新書き込み',
);
$list = array();
$displayNum = $sf_data->getRaw('widget')->getConfig('col');
for ($i = 0; $i < $displayNum; $i++) {
  $topicId = $communityTopic[$i]->getId();
  $topicName = $communityTopic[$i]->getName();
  $communityName = $communityTopic[$i]->getCommunity()->getName();
  $countComment = $communityTopic[$i]->countCommunityTopicComments();
  $updateTopic = $communityTopic[$i]->getUpdatedAt();

  $list[$updateTopic] = link_to($topicName.' ('.$countComment.')', 'communityTopic/detail?id='.$topicId).' ('.$communityName.')';
}

include_list_box('recentCommunityTopicComment', $list, $option);
