<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Delete Community Event')); ?>

<p><?php echo __('Do you really want to delete this event?') ?></p>

<form action="<?php url_for('communitytopic/eventDelete?id='.$event->getId()) ?>" method="post">
<?php include_partial('communitytopic/eventInfo', array(
  'event' => $event,
  'moreInfo' => array('<input type="submit" value="' . __('Delete') . '" />')
)); ?>
</form>

