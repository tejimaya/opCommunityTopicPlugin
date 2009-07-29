<?php use_helper('Date'); ?>

<?php

$list = array(
  'Name'                 => $communityEvent->getName(),
  'Open date'            => op_format_date($communityEvent->getOpenDate(), 'D'),
  'Area'                 => $communityEvent->getArea(),
  'Body'                 => nl2br($communityEvent->getBody()),
  'Application deadline' => op_format_date($communityEvent->getApplicationDeadline(), 'D'),
  'Capacity'             => $communityEvent->getCapacity(),
  'Count of Member'      => $communityEvent->getCommunityEventMember()->count(),
);

if ($list['Count of Member'])
{
  $list['Count of Member'] .= '('.link_to(__('See Member List'), '@communityEvent_memberList?id='.$communityEvent->getId()).')';
}

$i18nlist = array();
foreach ($list as $key => $value)
{
  $i18nlist[__($key, array(), 'community_event_form')] = $value;
}

$options = array(
  'title' => '['.$community->getName().'] '.__('Event'),
  'list'  => $i18nlist,
);
op_include_parts('listBox', 'communityEvent', $options);
?>


<?php if ($communityEvent->isEditable($sf_user->getMemberId())): ?>
<div class="operation">
<form action="<?php echo url_for('@communityEvent_edit?id='.$communityEvent->getId()) ?>" method="get">
<ul class="moreInfo button">
<li><input class="input_submit" type="submit" value="<?php echo __('Edit') ?>" /></li>
</ul>
</form>
</div>
<?php endif; ?>

<?php include_component('communityEventComment', 'list', array('communityEvent' => $communityEvent)) ?>

<?php if ($communityEvent->isCreatableCommunityEventComment($sf_user->getMemberId())): ?>
<form action="<?php echo url_for('@communityEvent_comment_create?id='.$communityEvent->getId()) ?>" method="post">
<div class="parts form">
<div class="partsHeading">
<h3><?php echo __('Post a new event comment') ?></h3>
</div>
<table>
<?php echo $form ?>
</table>
<div class="operation">
<ul class="moreInfo button">
<?php if (!$communityEvent->isClosed() && !$communityEvent->isExpired() && !$communityEvent->isAtCapacity()): ?>
<?php if ($communityEvent->isEventMember($sf_user->getMemberId())): ?>
<li><input name="cancel" class="input_submit" type="submit" value="<?php echo __('Cancel') ?>" /></li>
<?php else: ?>
<li><input name="participate" class="input_submit" type="submit" value="<?php echo __('Participate in this event') ?>" /></li>
<?php endif; ?>
<?php endif; ?>
<li><input name="comment" class="input_submit" type="submit" value="<?php echo __('Add a comment only') ?>" /></li>
</ul>
</div>
</div>
</form>
<?php endif; ?>

<?php op_include_line('linkLine', link_to('['.$community->getName().'] '.__('Community Top Page'), 'community/home?id='.$community->getId())) ?>
