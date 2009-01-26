<?php if ($community->isViewableCommunityTopic($sf_user->getMemberId())): ?>
<?php use_helper('Date'); ?>
<tr>
<th>コミュニティ掲示板</th>
<td>
<ul>
<?php if (count($communityTopics)): ?>
<?php foreach ($communityTopics as $key => $communityTopic): ?>
<li>
<?php echo format_datetime($communityTopic->getUpdatedAt(), 'f'); ?>
&nbsp;
<?php echo link_to(sprintf('%s(%d)', $communityTopic->getName(), $communityTopic->countCommunityTopicComments()), 'communityTopic_show', $communityTopic) ?>
</li>
<?php endforeach; ?>
<li><?php echo link_to('もっと読む', 'communityTopic_list_community', $community); ?></li>
<?php endif; ?>
<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<li><?php echo link_to('トピック作成', 'communityTopic_new', $community); ?></li>
<?php endif; ?>
</ul>
</td>
</tr>
<?php endif; ?>
