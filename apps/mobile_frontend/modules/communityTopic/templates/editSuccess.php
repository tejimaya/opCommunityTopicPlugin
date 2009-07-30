<?php op_mobile_page_title($communityTopic->getCommunity()->getName(), __('Edit the topic')) ?>

<?php
$options = array(
  'url' => url_for('communityTopic_update', $communityTopic),
  'button' => __('Edit')
);
op_include_form('formCommunityTopic', $form, $options);
?>

<?php
$options = array(
  'title' => __('Delete the topic and comments'),
  'button' => __('Delete'),
  'url' => url_for('communityTopic_delete_confirm', $communityTopic),
  'method' => 'get'
);
op_include_parts('buttonBox', 'toDelete', $options);
?>
