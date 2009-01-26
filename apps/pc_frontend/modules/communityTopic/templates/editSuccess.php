<?php
$options = array();
$options['title'] = 'トピック編集';
$options['url'] = '@communityTopic_update?id='.$communityTopic->getId();
op_include_form('formCommunityTopic', $form, $options);
?>

<?php
op_include_parts('buttonBox', 'toDelete', array(
  'title'  => __('Delete the topic and comments'),
  'button' => __('Delete'),
  'url' => '@communityTopic_delete_confirm?id='.$communityTopic->getId(),
  'method' => 'get',
));
?>
