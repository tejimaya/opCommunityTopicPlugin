<div class="dparts homeRecentList"><div class="parts">
<div class="partsHeading"><h3><?php echo __('Recently Posted Community Topics') ?></h3></div>
<div class="block">

<?php if (count($communityTopic)): ?>
<ul class="articleList">
<?php foreach ($communityTopic as $topic): ?>
<li><span class="date"><?php echo op_format_date($topic->getCreatedAt(), 'XShortDateJa') ?></span><?php echo link_to($topic->getName().' ('.$topic->countCommunityTopicComments().')', 'communityTopic_show', $topic).' ('.$topic->getCommunity()->getName().')' ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>

</div>
</div></div>
