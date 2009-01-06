<?php if ($hasPermission) : ?>
<?php use_helper('Date'); ?>
<tr>
<th>コミュニティ掲示板</th>
<td>
<ul>
<?php if ($communityTopics) : ?>
<?php foreach ($communityTopics as $key => $communityTopic) : ?>
<li>
<?php echo format_datetime($communityTopic->getUpdatedAt(), 'f'); ?>
&nbsp;
<?php echo link_to(sprintf('%s(%d)', $communityTopic->getName(), $communityTopic->countCommunityTopicComments()), 'communityTopic/detail?id='.$communityTopic->getId()); ?>
</li>
<?php endforeach; ?>
<li><?php echo link_to('もっと読む', 'communityTopic/list?community_id='.$community->getId()); ?></li>
<?php endif; ?>
<li><?php echo link_to('トピック作成', 'communityTopic/edit?community_id='.$community->getId()); ?></li>
</ul>
</td>
</tr>
<?php endif; ?>
