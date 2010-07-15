<?php
$options = array();
$options['title'] = __('Edit the event');
$options['url'] = url_for('communityEvent_update', $communityEvent);
$options['isMultipart'] = true;
op_include_form('formCommunityEvent', $form, $options);
?>

<?php
op_include_parts('buttonBox', 'toDelete', array(
  'title'  => __('Delete the event and comments'),
  'button' => __('Delete'),
  'url' => url_for('communityEvent_delete_confirm', $communityEvent),
  'method' => 'get',
));
?>
