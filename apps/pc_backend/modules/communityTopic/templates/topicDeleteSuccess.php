<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Delete Community Topic')); ?>

<p><?php echo __('Do you really want to delete this topic?') ?></p>

<form action="<?php url_for('communitytopic/topicDelete?id='.$topic->getId()) ?>" method="post">
<?php include_partial('communitytopic/topicInfo', array(
  'topic' => $topic,
  'moreInfo' => array('<input type="submit" value="' . __('Delete') . '" />')
)); ?>
</form>

