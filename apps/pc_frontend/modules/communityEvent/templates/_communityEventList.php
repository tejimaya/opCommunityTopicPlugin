<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>
<?php $sf_response->addStylesheet('/opCommunityTopicPlugin/css/communityTopic') ?>
<?php use_helper('Date'); ?>
<tr class="communityEvent">
<th><?php echo __('Community Events') ?></th>
<td>
<?php if ($count = count($communityEvents)): ?>
<ul class="articleList">
<?php foreach ($communityEvents as $key => $communityEvent): ?>
<li>
<span class="date"><?php echo op_format_date($communityEvent->getUpdatedAt(), 'XShortDateJa'); ?></span>
<?php echo link_to(sprintf('%s(%d)', op_truncate($communityEvent->getName(), 36), $communityEvent->getCommunityEventComment()->count()), '@communityEvent_show?id='.$communityEvent->getId()) ?>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<div class="moreInfo">
<ul class="moreInfo">
<?php if($count): ?>
<li><?php echo link_to(__('More'), '@communityEvent_list_community?id='.$community->getId()); ?></li>
<?php endif; ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
<li><?php echo link_to(__('Create a new event'), '@communityEvent_new?id='.$community->getId()); ?></li>
<?php endif; ?>
</ul>
</div>
</tr>
<?php endif; ?>
