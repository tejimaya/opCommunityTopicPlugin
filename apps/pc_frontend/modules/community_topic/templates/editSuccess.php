<?php
$options = array('form' => array($form));
if ($form->isNew()) {
  $title = 'トピック作成';
  $options['url'] = 'community_topic/edit?community_id='.$sf_params->get('community_id');
} else {
  $title = 'トピック編集';
  $options['url'] = 'community_topic/edit?id='.$communityTopic->getId();
}
include_box('formCommunityTopic', $title, '', $options);
?>
