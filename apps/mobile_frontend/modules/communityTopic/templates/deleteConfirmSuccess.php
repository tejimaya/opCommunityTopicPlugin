<?php op_include_form('deleteConfirmForm', $form, array(
  'button' => __('Delete'),
  'title' => __('Do you really delete this topic?'),
  'url' => url_for('@communityTopic_delete?id='.$communityTopic->getId())
)) ?>


