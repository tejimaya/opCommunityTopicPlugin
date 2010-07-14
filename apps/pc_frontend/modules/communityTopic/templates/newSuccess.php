<?php
$options = array();
$options['title'] = __('Create a new topic');
$options['url'] = url_for('communityTopic_create', $community);
$options['isMultipart'] = true;
op_include_form('formCommunityTopic', $form, $options);
?>
