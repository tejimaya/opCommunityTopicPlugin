<?php use_helper('Date'); ?>

<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<?php
op_include_parts('buttonBox', 'communityEventList', array(
  'title'  => __('Create a new event'),
  'button' => __('Create'),
  'url' => url_for('communityEvent_new', $community),
  'method' => 'get',
));
?>
<?php endif; ?>

<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('List of events') ?></h3>
</div>

<?php ob_start() ?>
<?php op_include_pager_navigation($pager, '@communityEvent_list_community?page=%d&id='.$community->getId()) ?>
<?php $pager_navi = ob_get_contents() ?>
<?php ob_end_flush() ?>

<?php foreach ($pager->getResults() as $event): ?>
<dl>
<dt><?php echo format_datetime($event->getUpdatedAt(), 'f') ?></dt>
<dd><?php echo link_to(sprintf($event->getName().'(%d)', $event->countCommunityEventComments()), 'communityEvent_show', $event) ?></dd>
</dl>
<?php endforeach; ?>

<?php echo $pager_navi ?>

</div>
</div>
<?php endif; ?>
