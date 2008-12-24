<?php
$options = array('form' => array($form));
if ($form->isNew()) {
  $title = 'トピック作成';
  $options['url'] = 'communityTopic/edit?community_id='.$sf_params->get('community_id');
} else {
  $title = 'トピック編集';
  $options['url'] = 'communityTopic/edit?id='.$communityTopic->getId();
}
include_box('formCommunityTopic', $title, '', $options);
?>
