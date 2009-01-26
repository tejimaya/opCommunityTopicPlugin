<?php op_include_form('deleteConfirmForm', $form, array(
  'button' => __('Delete'),
  'title'  => '本当に削除しますか？',
  'url'    => '@communityTopic_delete?id='.$communityTopic->getId(),
)) ?>

<?php use_helper('Javascript') ?> 
<?php op_include_line('backLink', link_to_function(__('Back to previous page'), 'history.back()')) ?>
