<?php
$options = array(
  'title' => __('Event Members'),
  'list' => $pager->getResults(),
  'link_to' => 'member/profile?id=',
  'pager' => $pager,
  'link_to_pager' => '@communityEvent_memberList?page=%d&id='.$communityEvent->getId(),
);
op_include_parts('photoTable', 'communityEventMembersList', $options);

if ($acl->isAllowed($sf_user->getMemberId(), null, 'edit'))
{
  op_include_parts('buttonBox', 'toEdit', array(
    'title'  => __('Manage the event member'),
    'button' => __('Edit'),
    'url' => url_for('communityEvent_memberManage', $communityEvent),
    'method' => 'get',
  ));
}
