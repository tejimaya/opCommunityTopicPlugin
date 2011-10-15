<?php op_include_box('noMembers', __('There are no event members.'), array('title' => __('Event Members'))) ?>

<?php
if ($acl->isAllowed($sf_user->getMemberId(), null, 'edit'))
{
  op_include_parts('buttonBox', 'toEdit', array(
    'title'  => __('Manage the event member'),
    'button' => __('Edit'),
    'url' => url_for('communityEvent_memberManage', $communityEvent),
    'method' => 'get',
  ));
}
?>

<?php use_helper('Javascript') ?>
<?php op_include_line('backLink', link_to_function(__('Back to previous page'), 'history.back()')) ?>
