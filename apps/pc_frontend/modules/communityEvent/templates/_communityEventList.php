<?php if ($community->isViewableCommunityTopic($sf_user->getMemberId())): ?>
<?php $sf_response->addStylesheet('/opCommunityTopicPlugin/css/communityTopic') ?>
<?php use_helper('Date'); ?>
<tr class="communityEvent">
<th><?php echo __('Community Events') ?></th>
<td>
<?php if ($count = count($communityEvents)): ?>
<ul class="articleList">
<?php foreach ($communityEvents as $key => $communityEvent): ?>
<li>
<span class="date"><?php echo op_format_date($communityEvent->getUpdatedAt(), 'XShortDateJa'); ?></span>
<?php echo link_to(sprintf('%s(%d)', op_truncate($communityEvent->getName(), 36), $communityEvent->countCommunityEventComments()), 'communityEvent_show', $communityEvent) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<div class="moreInfo">
<ul class="moreInfo">
<?php if($count): ?>
<li><?php echo link_to(__('More'), 'communityEvent_list_community', $community); ?></li>
<?php endif; ?>
<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<li><?php echo link_to(__('Create a new event'), 'communityEvent_new', $community); ?></li>
<?php endif; ?>
</ul>
</div>
</tr>
<?php endif; ?>
