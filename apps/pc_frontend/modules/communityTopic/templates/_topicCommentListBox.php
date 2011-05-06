<?php if (count($communityTopic)): ?>
<div id="homeRecentList_<?php echo $gadget->getId() ?>" class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted %Community% Topics') ?></h3></div>
<div class="block">
<ul class="articleList">
<?php foreach ($communityTopic as $topic): ?>
<li><span class="date"><?php echo op_format_date($topic->getUpdatedAt(), 'XShortDateJa') ?></span>
<?php echo sprintf('%s (%s)',
  link_to(sprintf('%s(%d)',
    op_truncate($topic->getName(), 36),
    $topic->getCommunityTopicComment()->count()
  ), '@communityTopic_show?id='.$topic->getId()),
  $topic->getCommunity()->getName()
) ?></li>
<?php endforeach; ?>
</ul>
<div class="moreInfo">
<ul class="moreInfo">
<li><?php echo link_to(__('More'), 'communityTopic_recently_topic_list') ?></li>
</ul>
</div>
</div>
</div></div>
<?php endif; ?>
