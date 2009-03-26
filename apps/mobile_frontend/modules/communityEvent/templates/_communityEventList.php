<?php if ($community->isViewableCommunityTopic($sf_user->getMemberId())): ?>
<?php use_helper('Date') ?>
<?php
$list = array();
foreach ($communityEvents as $communityEvent)
{
  $list[] = sprintf("[%s] %s",
    op_format_date($communityEvent->getUpdatedAt(), 'XShortDate'),
    link_to(sprintf("%s(%d)",
      op_truncate($communityEvent->getName(), 28),
      $communityEvent->countCommunityEventComments()
    ), 'communityEvent_show', $communityEvent
  ));
}
$moreInfo = array();
if (count($communityEvents))
{
  $moreInfo[] = link_to(__('More'), 'communityEvent_list_community', $community);
}
if ($community->isCreatableCommunityTopic($sf_user->getMemberId()))
{
  $moreInfo[] = link_to(__('Create a new event'), 'communityEvent_new', $community);
}
$option = array(
  'title' => __('Community Events'),
  'border' => true,
  'moreInfo' => $moreInfo,
);
op_include_list('communityEvent', $list, $option);
?>
<?php endif; ?>
