<?php use_helper('Date') ?>
<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Recently Posted Community Topics') ?></h3>
</div>

<?php ob_start() ?>
<?php op_include_pager_navigation($pager, '@communityTopic_recently_topic_list?page=%d') ?>
<?php $pager_navi = ob_get_contents() ?>
<?php ob_end_flush() ?>

<?php foreach ($pager->getResults() as $topic): ?>
<dl>
<dt><?php echo format_datetime($topic->getUpdatedAt(), 'f') ?></dt>
<dd>
<?php echo sprintf('%s (%s)',
  link_to(sprintf('%s(%d)',
    $topic->getName(),
    $topic->getCommunityTopicComment()->count()
  ),'communityTopic_show', $topic),
  $topic->getCommunity()->getName()
)
?></dd>
</dl>
<?php endforeach; ?>

<?php echo $pager_navi ?>

</div>
</div>
<?php endif; ?>
