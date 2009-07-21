<?php use_helper('Date'); ?>
<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
<?php
op_include_parts('buttonBox', 'communityTopicList', array(
  'title'  => __('Create a new topic'),
  'button' => __('Create'),
  'url' => url_for('communityTopic_new', $community),
  'method' => 'get',
));
?>
<?php endif; ?>

<?php if ($pager->getNbResults()): ?>
<div class="dparts recentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('List of topics') ?></h3>
</div>

<?php ob_start() ?>
<?php op_include_pager_navigation($pager, '@communityTopic_list_community?page=%d&id='.$community->getId()) ?>
<?php $pager_navi = ob_get_contents() ?>
<?php ob_end_flush() ?>

<?php foreach ($pager->getResults() as $topic): ?>
<dl>
<dt><?php echo format_datetime($topic->getUpdatedAt(), 'f') ?></dt>
<dd><?php echo link_to(sprintf($topic->getName().'(%d)', $topic->getCommunityTopicComment()->count()), '@communityTopic_show?id='.$topic->getId()) ?></dd>
</dl>
<?php endforeach; ?>

<?php echo $pager_navi ?>

</div>
</div>
<?php endif; ?>
