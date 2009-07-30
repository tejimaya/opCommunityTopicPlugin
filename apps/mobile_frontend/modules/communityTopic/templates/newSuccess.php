<?php op_mobile_page_title($community->getName(), __('Create a new topic')) ?>

<?php
op_include_form('formCommunityTopic', $form, array(
  'url' => url_for('communityTopic_create', $community),
  'button' => __('Create')
));
