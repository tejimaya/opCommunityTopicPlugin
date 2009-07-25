<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Delete Community Event Comment')); ?>

<p><?php echo __('Do you really want to delete this event comment?') ?></p>

<form action="<?php url_for('communitytopic/eventCommentDelete?id='.$eventComment->getId()) ?>" method="post">
<?php include_partial('communitytopic/eventCommentInfo', array(
  'eventComment' => $eventComment,
  'moreInfo' => array('<input type="submit" value="' . __('Delete') . '" />')
)); ?>
</form>

