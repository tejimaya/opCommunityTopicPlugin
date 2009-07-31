<?php op_mobile_page_title($community->getName(), __('Create a new event')) ?>

<?php
op_include_form('formCommunityEvent', $form, array(
  'url' => url_for('communityEvent_create', $community),
  'button' => __('Create')
));
