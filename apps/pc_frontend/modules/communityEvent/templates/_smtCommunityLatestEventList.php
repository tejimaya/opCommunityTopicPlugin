<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'view')): ?>

<?php
use_helper('Javascript', 'opUtil', 'opAsset');
$count = $communityEvents->count();
?>
<hr class="toumei" />
<div class="row">
<div class="gadget_header span12"><?php echo __('List of events of this %Community%') ?></div>
</div>
<hr class="toumei" />
<div id="eventList" style="margin-left: 0px;">
<?php if ($count): ?>
  <?php foreach ($communityEvents as $communityEvent): ?>
    <div class="row">
      <div class="span3"><?php echo op_format_date($communityEvent->getUpdatedAt(), 'XShortDateJa') ?></div>
      <div class="span9"><?php echo link_to(sprintf('%s', op_truncate($communityEvent->getName(), 36)), '@communityEvent_show?id='.$communityEvent->getId()) ?></div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <div class="row"><p>表示する情報がありません。</p></div>
<?php endif; ?>
</div>

<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'add')): ?>
  <div class="row" id="new-topic-link">
    <?php echo link_to(__('Create a new event'), '@communityEvent_new?id='.$community->getId()) ?>
  </div>
<?php endif; ?>
<?php if ($count): ?>
  <div class="row" id="eventreadmore">
  <?php echo link_to(__('More'), 'communityEvent/listCommunity?id='.$community->getId(), array('class' => 'btn btn-block span11')) ?>
</div>
<?php endif; ?>

<?php endif; ?>
