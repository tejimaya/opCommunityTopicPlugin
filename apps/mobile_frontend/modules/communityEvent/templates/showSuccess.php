<?php op_mobile_page_title($community->getName(), $communityEvent->getName()) ?>

<?php echo op_within_page_link() ?>
<?php echo op_format_date($communityEvent->getEventUpdatedAt(), 'XDateTime') ?>
<?php if ($communityEvent->getMemberId() === $sf_user->getMemberId()): ?>
<?php endif; ?>
<?php if ($communityEvent->isEditable($sf_user->getMemberId())): ?>
&nbsp;[<?php echo link_to(__('Edit') ,'communityEvent_edit', $communityEvent) ?>]
<?php endif ?>
<br>
<?php
$list = array(
  'Writer'               => link_to($communityEvent->getMember()->getName(), 'member/profile?id='.$communityEvent->getMember()->getId()),
  'Name'                 => $communityEvent->getName(),
  'Open date'            => op_format_date($communityEvent->getOpenDate(), 'D'),
  'Area'                 => $communityEvent->getArea(),
  'Body'                 => nl2br($communityEvent->getBody()),
  'Application deadline' => op_format_date($communityEvent->getApplicationDeadline(), 'D'),
  'Capacity'             => $communityEvent->getCapacity(),
  'Count of Member'      => $communityEvent->countCommunityEventMembers(),
);

if ($list['Count of Member'])
{
  $list['Count of Member'] .= '('.link_to(__('See Member List'), '@communityEvent_memberList?id='.$communityEvent->getId()).')';
}

foreach ($list as $key => $value)
{
  echo '<font color="#999966">'.__($key, array(), 'community_event_form').':</font><br>'.$value.'<br>';
}
?>

<?php include_component('communityEventComment', 'list', array('communityEvent' => $communityEvent)) ?>

<?php echo op_within_page_link('') ?>
<?php if ($communityEvent->isCreatableCommunityEventComment($sf_user->getMemberId())): ?>
<hr>
<div id="formEventComment">
<table width="100%">
<tbody><tr><td bgcolor="#7ddadf">
<font color="#000000"><?php echo __('Post a new event comment') ?></font><br>
</td></tr>
</tbody></table>
<table>
<form action="<?php echo url_for('communityEvent_comment_create', $communityEvent) ?>" method="post">
<?php echo $form ?>
<?php if ($communityEvent->isEventMember($sf_user->getMemberId())): ?>
<input name="cancel" class="input_submit" type="submit" value="<?php echo __('Cancel') ?>" />
<?php else: ?>
<input name="participate" class="input_submit" type="submit" value="<?php echo __('Participate in this event') ?>" />
<?php endif; ?>
<input name="comment" class="input_submit" type="submit" value="<?php echo __('Add a comment only') ?>" />
</form>
</table>
</div>
<?php endif; ?>
<hr>

<?php echo link_to(__('List of events'), 'communityEvent_list_community', $community) ?><br>
<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
