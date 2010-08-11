<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Delete Community Event Comment')); ?>

<p><?php echo __('Do you really want to delete this event comment?') ?></p>

<?php $form = new BaseForm() ?>
<form action="<?php echo url_for('communityTopic/eventCommentDelete?id='.$eventComment->getId()) ?>" method="post">
<?php echo $form->renderHiddenFields() ?>
<?php include_partial('communityTopic/eventCommentInfo', array(
  'eventComment' => $eventComment,
  'moreInfo' => array('<input type="submit" value="' . __('Delete') . '" />')
)); ?>
</form>

