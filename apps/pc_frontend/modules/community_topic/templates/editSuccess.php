<?php
$options = array('form' => array($form));
if ($form->isNew()) {
  $title = 'トピック作成';
  $options['url'] = 'community_topic/edit';
} else {
  $title = 'トピック編集';
  $options['url'] = 'community_topic/edit?id=' . $community_topic->getId();
}
include_box('formCommunityTopic', $title, '', $options);
?>
