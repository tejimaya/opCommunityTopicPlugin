<?php op_include_form('deleteConfirmForm', $form, array(
  'button' => __('Delete'),
  'title'  => __('Do you really delete this event?'),
  'url'    => url_for('communityEvent_delete', $communityEvent),
)) ?>
