<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Delete Community Topic Comment')); ?>

<p><?php echo __('Do you really want to delete this topic comment?') ?></p>

<?php $form = new BaseForm() ?>
<form action="<?php echo url_for('communityTopic/topicCommentDelete?id='.$topicComment->getId()) ?>" method="post">
<?php echo $form->renderHiddenFields() ?>
<?php include_partial('communityTopic/topicCommentInfo', array(
  'topicComment' => $topicComment,
  'moreInfo' => array('<input type="submit" value="' . __('Delete') . '" />')
)); ?>
</form>
