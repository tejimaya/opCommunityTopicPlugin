<table>
<tr><th><?php echo __('Event ID') ?></th><td><?php echo $event->getId() ?></td></tr>
<tr><th><?php echo __('Event Title') ?></th><td><?php echo $event->getName() ?></td></tr>
<tr><th><?php echo __('Event Description') ?></th><td><?php echo $event->getBody() ?></td></tr>
<tr><th><?php echo __('Open Date') ?></th><td><?php echo $event->getOpenDate() ?></td></tr>
<tr><th><?php echo __('Created Date') ?></th><td><?php echo $event->getCreatedAt() ?></td></tr>
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

