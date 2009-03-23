<?php
op_include_form('formCommunityTopic', $form, array(
  'title' => __('Create a new topic'),
  'url' => url_for('communityTopic_create', $community),
  'button' => __('Create')
));
