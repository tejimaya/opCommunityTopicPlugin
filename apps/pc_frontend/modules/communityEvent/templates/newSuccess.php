<?php
$options = array();
$options['title'] = __('Create a new event');
$options['url'] = url_for('communityEvent_create', $community);
op_include_form('formCommunityEvent', $form, $options);
?>
