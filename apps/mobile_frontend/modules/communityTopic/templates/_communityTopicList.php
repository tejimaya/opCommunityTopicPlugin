<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>
<?php use_helper('Date') ?>
<?php
$list = array();
foreach ($communityTopics as $communityTopic)
{
  $list[] = sprintf("[%s] %s",
    op_format_date($communityTopic->getUpdatedAt(), 'XShortDate'),
    link_to(sprintf("%s(%d)",
      op_truncate($communityTopic->getName(), 28),
      $communityTopic->getCommunityTopicComment()->count()
    ), '@communityTopic_show?id='.$communityTopic->getId()
  ));
}
$moreInfo = array();
if (count($communityTopics))
{
  $moreInfo[] = link_to(__('More'), '@communityTopic_list_community?id='.$community->getId());
}
if ($acl->isAllowed($sf_user->getMemberId(), null, 'add'))
{
  $moreInfo[] = link_to(__('Create a new topic'), '@communityTopic_new?id='.$community->getId());
}
$option = array(
  'title' => __('Recently Posted This Community Topics'),
  'border' => true,
  'moreInfo' => $moreInfo
);
op_include_list('communityTopic', $list, $option);
?>
<?php endif; ?>
