<?php if (count($communityEvent)): ?>
<div id="homeRecentList_<?php echo $gadget->getId() ?>" class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted %Community% Events') ?></h3></div>
<div class="block">
<ul class="articleList">
<?php foreach ($communityEvent as $event): ?>
<li><span class="date"><?php echo op_format_date($event->getUpdatedAt(), 'XShortDateJa') ?></span>
<?php echo sprintf('%s (%s)',
  link_to(sprintf('%s(%d)',
    op_truncate($event->getName(), 36),
    $event->getCommunityEventComment()->count()
  ), '@communityEvent_show?id='.$event->getId()),
  $event->getCommunity()->getName()
) ?></li>
<?php endforeach; ?>
</ul>
<div class="moreInfo">
<ul class="moreInfo">
<li><?php echo link_to(__('More'), 'communityEvent_recently_event_list') ?></li>
</ul>
</div>
</div>
</div></div>
<?php endif; ?>
