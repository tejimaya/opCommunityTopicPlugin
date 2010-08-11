<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Delete Community Event Member')); ?>

<p><?php echo __('Do you really want to delete this event member?') ?></p>

<?php $form = new BaseForm() ?>
<form action="<?php echo url_for('communityTopic/eventMemberDelete?id='.$eventMember->getId()) ?>" method="post">
<?php echo $form->renderHiddenFields() ?>
<?php include_partial('communityTopic/eventMemberInfo', array(
  'eventMember' => $eventMember,
  'moreInfo' => array('<input type="submit" value="' . __('Delete') . '" />')
)); ?>
</form>

