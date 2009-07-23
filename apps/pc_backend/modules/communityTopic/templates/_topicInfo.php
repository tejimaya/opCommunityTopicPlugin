<table>
<tr><th><?php echo __('Topic ID') ?></th><td><?php echo $topic->getId() ?></td></tr>
<tr><th><?php echo __('Topic Title') ?></th><td><?php echo $topic->getName() ?></td></tr>
<tr><th><?php echo __('Topic Description') ?></th><td><?php echo $topic->getBody() ?></td></tr>
<tr><th><?php echo __('Created Date') ?></th><td><?php echo $topic->getCreatedAt() ?></td></tr>
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

