<?php use_helper('Date') ?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Recently Posted Community Events') ?></h3>
</div>

<?php ob_start() ?>
<?php op_include_pager_navigation($pager, '@communityEvent_recently_event_list?page=%d') ?>
<?php $pager_navi = ob_get_contents() ?>
<?php ob_end_flush() ?>

<?php foreach ($pager->getResults() as $event): ?>
<dl>
<dt><?php echo format_datetime($event->getUpdatedAt(), 'f') ?></dt>
<dd>
<?php echo sprintf('%s (%s)',
  link_to(sprintf('%s(%d)',
    $event->getName(),
    $event->getCommunityEventComment()->count()
  ), '@communityEvent_show?id='.$event->getId()),
  $event->getCommunity()->getName()
)
?></dd>
</dl>
<?php endforeach; ?>

<?php echo $pager_navi ?>

</div>
</div>
<?php endif; ?>
