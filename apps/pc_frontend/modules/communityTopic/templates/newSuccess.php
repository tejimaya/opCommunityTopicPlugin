<?php
$options = array();
$options['title'] = __('Create a new topic');
$options['url'] = '@communityTopic_create?id='.$community->getId();
op_include_form('formCommunityTopic', $form, $options);
?>
