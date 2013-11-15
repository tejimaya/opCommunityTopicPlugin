<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>

<?php
use_helper('Javascript', 'opUtil', 'opAsset');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
$count = $communityTopics->count();
?>
<hr class="toumei" />
<div class="row">
<div class="gadget_header span12"><?php echo __('List of topics of this community') ?></div>
</div>
<hr class="toumei" />
<div id="topicList" style="margin-left: 0px;">
<?php if ($count): ?>
  <?php foreach ($communityTopics as $communityTopic): ?>
    <div class="row">
      <div class="span3"><?php echo op_format_date($communityTopic->getUpdatedAt(), 'XShortDateJa') ?></div>
      <div class="span9"><?php echo link_to(sprintf('%s', op_truncate($communityTopic->getName(), 36)), '@communityTopic_show?id='.$communityTopic->getId()) ?></div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="row"><p>表示する情報がありません。</p></div>
<?php endif; ?>
</div>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
  <div class="row" id="new-topic-link">
  <?php echo link_to(__('Create a new topic'), '@communityTopic_new?id='.$community->getId()) ?>
  </div>
<?php endif; ?>
<?php if ($count): ?>
  <div class="row" id="topicreadmore">
  <?php echo link_to(__('More'), 'communityTopic/listCommunity?id='.$community->getId(), array('class' => 'btn btn-block span11')) ?>
  </div>
<?php endif; ?>

<?php endif; ?>
