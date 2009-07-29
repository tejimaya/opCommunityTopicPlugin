<?php op_mobile_page_title($community->getName(), $communityEvent->getName()) ?>

<?php echo op_within_page_link() ?>
<?php
$list = array(
  'Writer'               => link_to($communityEvent->getMember()->getName(), 'member/profile?id='.$communityEvent->getMember()->getId()),
  'Open date'            => op_format_date($communityEvent->getOpenDate(), 'D'),
  'Area'                 => $communityEvent->getArea(),
  'Capacity'             => $communityEvent->getCapacity() ? $communityEvent->getCapacity() : __('Limitless'),
  'Count of Member'      => __('%1% persons', array('%1%' => $communityEvent->countCommunityEventMembers())),
  'Body'                 => nl2br($communityEvent->getBody()).'<br>'.op_format_date($communityEvent->getCreatedAt(), 'MM/dd HH:mm'),
);

if ($communityEvent->countCommunityEventMembers())
{
  $list['Count of Member'] .= '<br>'.link_to(__('See Member List'), '@communityEvent_memberList?id='.$communityEvent->getId());
}

if ($communityEvent->getApplicationDeadline())
{
  $list['Application deadline'] = op_format_date($communityEvent->getApplicationDeadline(), 'D');
}

if ($communityEvent->isEditable($sf_user->getMemberId()))
{
  $list[__('Edit this event')] = link_to(__('See event edit form'), '@communityEvent_edit?id='.$communityEvent->getId());
}

foreach ($list as $key => $value)
{
  echo '<br>'.__($key, array(), 'community_event_form').':<br>'.$value.'<br>';
}
?>

<?php include_component('communityEventComment', 'list', array('communityEvent' => $communityEvent)) ?>

<?php echo op_within_page_link('') ?>
<?php if ($communityEvent->isCreatableCommunityEventComment($sf_user->getMemberId())): ?>
<hr>
<div id="formEventComment">
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

<?php echo link_to(__('List of events'), '@communityEvent_list_community?id='.$community->getId()) ?><br>
<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
