<?php
$options = array();
$options['title'] = __('Edit the topic');
$options['url'] = url_for('communityTopic_update', $communityTopic);
$options['isMultipart'] = true;
op_include_form('formCommunityTopic', $form, $options);
?>

<?php
op_include_parts('buttonBox', 'toDelete', array(
  'title'  => __('Delete the topic and comments'),
  'button' => __('Delete'),
  'url' => url_for('communityTopic_delete_confirm', $communityTopic),
  'method' => 'get',
));
?>
