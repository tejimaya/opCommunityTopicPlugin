<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>
<?php use_helper('Date') ?>
<?php
$list = array();
foreach ($communityEvents as $communityEvent)
{
  $list[] = sprintf("[%s] %s",
    op_format_date($communityEvent->getUpdatedAt(), 'XShortDate'),
    link_to(sprintf("%s(%d)",
      op_truncate($communityEvent->getName(), 28),
      $communityEvent->getCommunityEventComment()->count()
    ), 'communityEvent_show', $communityEvent
  ));
}
$moreInfo = array();
if (count($communityEvents))
{
  $moreInfo[] = link_to(__('More'), 'communityEvent_list_community', $community);
}
if ($acl->isAllowed($sf_user->getMemberId(), null, 'add'))
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
