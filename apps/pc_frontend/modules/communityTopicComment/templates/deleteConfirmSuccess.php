<?php op_include_form('deleteConfirmForm', $form, array(
  'button' => __('Delete'),
  'title'  => '本当に削除しますか？',
  'url'    => '@communityTopic_comment_delete?id='.$communityTopicComment->getId(),
)) ?>

<?php use_helper('Javascript') ?> 
<p><?php echo link_to_function(__('Back to previous page'), 'history.back()') ?></p>
