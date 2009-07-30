<?php op_mobile_page_title($community->getName(), __('List of events')) ?>

<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php echo pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $event)
{
  $list_str = op_format_date($event->getUpdatedAt(), 'XDateTime');

  if ($event->isEditable($sf_user->getMemberId()))
  {
    $list_str .= sprintf('&nbsp;[%s]', link_to(__('Edit'), '@communityEvent_edit?id='.$event->getId()));
  }

  $list_str .= '<br>'
    .link_to(sprintf("%s(%d)",
      op_truncate($event->getName(), 28),
      $event->getCommunityEventComment()->count()
    ), '@communityEvent_show?id='.$event->getId());

  $list[] = $list_str;
}
$options = array(
  'border' => true,
);
op_include_list('communityEventList', $list, $options);
?>

<?php if ($pager->haveToPaginate()): ?>
<?php op_include_pager_navigation($pager, 'communityEvent/listCommunity?id='.$community->getId().'&page=%d', array('is_total' => false)) ?>
<?php endif; ?>

<hr color="<?php echo $op_color['core_color_11'] ?>">

<?php else: ?>

<?php echo __('There are no events') ?>

<?php endif; ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
<?php echo link_to(__('Create a new event'), '@communityEvent_new?id='.$community->getId()) ?><br>
<?php endif; ?>
<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
