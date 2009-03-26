<?php op_mobile_page_title($community->getName(), __('List of events')) ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php echo pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $event)
{
  $list[] = sprintf("%s<br>%s",
    op_format_date($event->getUpdatedAt(), 'XDateTime'),
    link_to(sprintf("%s(%d)",
      op_truncate($event->getName(), 28),
      $event->countCommunityEventComments()
    ), 'communityEvent_show', $event)
  );
}
$options = array(
  'border' => true,
);
op_include_list('communityEventList', $list, $options);
?>

<?php if ($pager->haveToPaginate()): ?>
<?php op_include_pager_navigation($pager, 'communityEvent/listCommunity?id='.$community->getId().'&page=%d', array('is_total' => false)) ?>
<?php endif; ?>

<?php else: ?>

<?php echo __('There are no events') ?>

<?php endif; ?>

<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
