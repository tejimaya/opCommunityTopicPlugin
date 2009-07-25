<table>
<tr><th><?php echo __('Event ID') ?></th><td><?php echo $eventComment->getCommunityEventId() ?></td></tr>
<tr><th><?php echo __('Comment Number') ?></th><td><?php echo $eventComment->getNumber() ?></td></tr>
<tr><th><?php echo __('Nickname') ?></th><td><?php echo $eventComment->Member->getName() ?></td></tr>
<tr><th><?php echo __('Event Comment Description') ?></th><td><?php echo $eventComment->getBody() ?></td></tr>
<tr><th><?php echo __('Created Date') ?></th><td><?php echo $eventComment->getCreatedAt() ?></td></tr>
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

