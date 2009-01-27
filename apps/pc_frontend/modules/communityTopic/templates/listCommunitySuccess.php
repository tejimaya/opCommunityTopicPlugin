<?php use_helper('Date'); ?>

<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<?php
op_include_parts('buttonBox', 'communityTopicList', array(
  'title'  => __('Create a new topic'),
  'button' => __('Create'),
  'url' => '@communityTopic_new?id='.$community->getId(),
  'method' => 'get',
));
?>
<?php endif; ?>

<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('List of topics') ?></h3>
</div>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, '@communityTopic_list_community?page=%d&id='.$community->getId()) ?></p></div>

<?php foreach ($pager->getResults() as $topic): ?>
<dl>
<dt><?php echo format_datetime($topic->getUpdatedAt(), 'f') ?></dt>
<dd><?php echo link_to(sprintf($topic->getName().'(%d)', $topic->countCommunityTopicComments()), 'communityTopic_show', $topic) ?></dd>
</dl>
<?php endforeach; ?>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, '@communityTopic_list_community?page=%d&id='.$community->getId()) ?></p></div>

</div>
</div>
<?php endif; ?>
