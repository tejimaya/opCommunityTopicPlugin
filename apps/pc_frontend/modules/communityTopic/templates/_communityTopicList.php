<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>
<?php $sf_response->addStylesheet('/opCommunityTopicPlugin/css/communityTopic') ?>
<?php use_helper('Date'); ?>
<tr class="communityTopic">
<th><?php echo __('Community Topics') ?></th>
<td>
<?php if ($count = count($communityTopics)): ?>
<ul class="articleList">
<?php foreach ($communityTopics as $key => $communityTopic): ?>
<li>
<span class="date"><?php echo op_format_date($communityTopic->getUpdatedAt(), 'XShortDateJa'); ?></span>
<?php echo link_to(sprintf('%s(%d)', op_truncate($communityTopic->getName(), 36), $communityTopic->getCommunityTopicComment()->count()), '@communityTopic_show?id='.$communityTopic->getId()) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<div class="moreInfo">
<ul class="moreInfo">
<?php if($count): ?>
<li><?php echo link_to(__('More'), '@communityTopic_list_community?id='.$community->getId()); ?></li>
<?php endif; ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
<li><?php echo link_to(__('Create a new topic'), '@communityTopic_new?id='.$community->getId()); ?></li>
<?php endif; ?>
</ul>
</div>
</tr>
<?php endif; ?>
