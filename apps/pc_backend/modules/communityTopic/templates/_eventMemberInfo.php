<table>
<tr><th><?php echo __('Event ID') ?></th><td><?php echo $eventMember->getCommunityEventId() ?></td></tr>
<tr><th><?php echo __('Event Title') ?></th><td><?php echo $eventMember->CommunityEvent->getName()?></td></tr>
<tr><th><?php echo __('Nickname') ?></th><td><?php echo $eventMember->Member->getName() ?></td></tr>
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

