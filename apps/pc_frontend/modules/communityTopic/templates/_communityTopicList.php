<?php if ($community->isViewableCommunityTopic($sf_user->getMemberId())): ?>
<?php $sf_response->addStylesheet('/opCommunityTopicPlugin/css/communityTopic') ?>
<?php use_helper('Date'); ?>
<tr class="communityTopic">
<th><?php echo __('Community Topics') ?></th>
<td>
<?php if ($count = count($communityTopics)): ?>
<ul class="articleList">
<?php foreach ($communityTopics as $key => $communityTopic): ?>
<li>
<span class="date"><?php echo op_format_date($communityTopic->getUpdatedAt(), 'XShortDateJa'); ?></span>
<?php echo link_to(sprintf('%s(%d)', op_truncate($communityTopic->getName(), 36), $communityTopic->countCommunityTopicComments()), 'communityTopic_show', $communityTopic) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<div class="moreInfo">
<ul class="moreInfo">
<?php if($count): ?>
<li><?php echo link_to(__('More'), 'communityTopic_list_community', $community); ?></li>
<?php endif; ?>
<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<li><?php echo link_to(__('Create a new topic'), 'communityTopic_new', $community); ?></li>
<?php endif; ?>
</ul>
</div>
</tr>
<?php endif; ?>
