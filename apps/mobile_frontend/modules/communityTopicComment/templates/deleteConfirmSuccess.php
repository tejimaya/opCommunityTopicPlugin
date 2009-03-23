<?php op_include_form('deleteConfirmForm', $form, array(
  'button' => __('Delete'),
  'title'  => __('Do you really delete this comment?'),
  'url'    => url_for('communityTopic_comment_delete', $communityTopicComment),
)) ?>

