<?php if ($community->isViewableCommunityTopic($sf_user->getMemberId())): ?>
<?php use_helper('Date'); ?>
<tr>
<th><?php echo __('コミュニティ掲示板') ?></th>
<td>
<ul>
<?php if (count($communityTopics)): ?>
<?php foreach ($communityTopics as $key => $communityTopic): ?>
<li>
<span class="date"><?php echo op_format_date($communityTopic->getUpdatedAt(), 'XShortDateJa'); ?></span>
<?php echo link_to(sprintf('%s(%d)', $communityTopic->getName(), $communityTopic->countCommunityTopicComments()), 'communityTopic_show', $communityTopic) ?>
</li>
<?php endforeach; ?>
<li><?php echo link_to(__('More'), 'communityTopic_list_community', $community); ?></li>
<?php endif; ?>
<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<li><?php echo link_to(__('トピック作成'), 'communityTopic_new', $community); ?></li>
<?php endif; ?>
</ul>
</td>
</tr>
<?php endif; ?>
