<?php if (count($communityEvent)): ?>
<?php slot('body') ?>
<?php foreach ($communityEvent as $event): ?>
<li><span class="date"><?php echo op_format_date($event->getUpdatedAt(), 'XShortDateJa') ?></span>
<?php echo sprintf('%s (%s)',
  link_to(sprintf('%s(%d)',
    op_truncate($event->getName(), 36),
    $event->getCommunityEventComment()->count()
  ), '@communityEvent_show?id='.$event->getId()),
  $event->getCommunity()->getName()
) ?></li>
<?php endforeach ?>
<?php end_slot() ?>
<?php echo op_include_parts('eventRecentList', 'homeRecentList_'.$gadget->id, array(
  'title' => 'SNS全体のコミュニティ最新イベント',
  'listBody' => get_slot('body'),
  'moreInfo' => array(
    link_to(__('More'), array('sf_route' => 'communityEvent_search_all', 'type' => 'event')),
  ),
)) ?>
<?php endif ?>
