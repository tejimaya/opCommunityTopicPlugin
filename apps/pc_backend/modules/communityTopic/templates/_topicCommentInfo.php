<table>
<tr><th><?php echo __('Topic ID') ?></th><td><?php echo $topicComment->getCommunityTopicId() ?></td></tr>
<tr><th><?php echo __('Comment Number') ?></th><td><?php echo $topicComment->getNumber() ?></td></tr>
<tr><th><?php echo __('Nickname') ?></th><td><?php echo $topicComment->Member->getName() ?></td></tr>
<tr><th><?php echo __('Topic Comment Description') ?></th><td><?php echo $topicComment->getBody() ?></td></tr>
<tr><th><?php echo __('Created Date') ?></th><td><?php echo $topicComment->getCreatedAt() ?></td></tr>
<?php if ($moreInfo): ?>
<tr><td colspan="2">
<ul>
<?php foreach ($sf_data->getRaw('moreInfo') as $more): ?>
<li><?php echo $more ?></li>
<?php endforeach; ?>
</ul>
</td></tr>
<?php endif; ?>
</table>

