<?php op_include_form('deleteConfirmForm', $form, array(
  'button' => __('Delete'),
  'title'  => __('Do you really delete this topic?'),
  'url'    => '@communityTopic_delete?id='.$communityTopic->getId(),
)) ?>

<?php use_helper('Javascript') ?> 
<?php op_include_line('backLink', link_to_function(__('Back to previous page'), 'history.back()')) ?>
