<?php use_helper('Date'); ?>

<?php

$list = array(
  'Name'                 => $communityEvent->getName(),
  'Open date'            => $communityEvent->getOpenDate(),
  'Area'                 => $communityEvent->getArea(),
  'Application deadline' => $communityEvent->getApplicationDeadline(),
  'Capacity'             => $communityEvent->getCapacity(),
  'Body'                 => nl2br($communityEvent->getBody()),
);

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
<form action="<?php echo url_for('communityEvent_edit', $communityEvent) ?>" method="get">
<ul class="moreInfo button">
<li><input class="input_submit" type="submit" value="<?php echo __('Edit') ?>" /></li>
</ul>
</form>
</div>
<?php endif; ?>

<?php include_component('communityEventComment', 'list', array('communityEvent' => $communityEvent)) ?>

<?php if ($communityEvent->isCreatableCommunityEventComment($sf_user->getMemberId())): ?>
<?php
$options = array();
$options['title'] = __('Post a new event comment');
$options['url'] = url_for('communityEvent_comment_create', $communityEvent);
op_include_form('formCommunityEventComment', $form, $options);
?>
<?php endif; ?>

<?php op_include_line('linkLine', link_to('['.$community->getName().'] '.__('Community Top Page'), 'community/home?id='.$community->getId())) ?>
