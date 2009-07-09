<?php op_mobile_page_title($community->getName(), __('Topic List')) ?>

<?php if ($pager->getNbResults()): ?>

<center>
<?php echo pager_total($pager); ?>
</center>
<?php
$list = array();
foreach ($pager->getResults() as $topic)
{
  $list_str = op_format_date($topic->getUpdatedAt(), 'XDateTime');

  if ($topic->getMemberId() === $sf_user->getMemberId())
  {
    $list_str .= sprintf('&nbsp;[%s]', link_to(__('Edit') ,'communityEvent_edit', $topic));
  }

  $list_str .= '<br>'
    .link_to(sprintf("%s(%d)",
      op_truncate($topic->getName(), 28),
      $topic->getCommunityTopicComment()->count()
    ), 'communityTopic_show', $topic);

  $list[] = $list_str;
}
$options = array(
  'border' => true,
);
op_include_list('communityTopicList', $list, $options);
?>

<?php if ($pager->haveToPaginate()): ?>
<?php op_include_pager_navigation($pager, 'communityTopic/listCommunity?id='.$community->getId().'&page=%d', array('is_total' => false)) ?>
<?php endif; ?>

<?php else: ?>

<?php echo __('There are no topics') ?>

<?php endif; ?>

<?php echo link_to(__('Create a new topic'), 'communityTopic_new', $community) ?><br>
<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
