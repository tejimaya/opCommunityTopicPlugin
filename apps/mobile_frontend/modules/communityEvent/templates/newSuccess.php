<?php
op_include_form('formCommunityEvent', $form, array(
  'title' => __('Create a new event'),
  'url' => url_for('communityEvent_create', $community),
  'button' => __('Create')
));
