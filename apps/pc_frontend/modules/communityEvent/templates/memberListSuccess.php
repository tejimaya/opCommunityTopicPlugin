<?php
$options = array(
  'title' => __('Event Members'),
  'list' => $pager->getResults(),
  'link_to' => 'member/profile?id=',
  'pager' => $pager,
  'link_to_pager' => '@communityEvent_memberList?page=%d&id='.$communityEvent->getId(),
);
op_include_parts('photoTable', 'communityEventMembersList', $options)
?>
