<?php op_mobile_page_title(__('Recently Posted Community Events')) ?>

<?php if ($pager->getNbResults()): ?>
<?php use_helper('Date') ?>

<center>
<?php echo pager_total($pager) ?>
</center>

<?php
$list = array();
foreach ($pager->getResults() as $event)
{
  $list[] = sprintf("%s<br>%s (%s)",
    op_format_date($event->getUpdatedAt(), 'XDateTime'),
    link_to(sprintf("%s(%d)",
        op_truncate($event->getName(), 28),
        $event->getCommunityEventComment()->count()
      ), '@communityEvent_show?id='.$event->getId()
    ),
    op_truncate($event->getCommunity()->getName(), 28)
  );
}
$options = array(
  'border' => true,
);
op_include_list('communityList', $list, $options);
?>

<?php if ($pager->haveToPaginate()): ?>
<?php op_include_pager_navigation($pager, '@communityEvent_recently_event_list?page=%d', array('is_total' => false)) ?>
<?php endif; ?>

<?php endif; ?>
