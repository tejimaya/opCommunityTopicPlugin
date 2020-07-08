<?php
use_helper('Javascript', 'opUtil', 'opAsset');
?>
<hr class="toumei" />
<div class="row">
  <div class="gadget_header span12"><?php echo __('List of %Community% topics for all SNS') ?></div>
</div>
<hr class="toumei" />
<div id="topicList" style="margin-left: 0px;">
<?php foreach ($communityTopics as $key => $communityTopic): ?>
  <div class="row">
    <div class="span3">
      <?php echo op_format_date($communityTopic->getUpdatedAt(), 'XShortDateJa'); ?>
    </div>
    <div class="span9">
    <?php echo link_to(sprintf('%s', op_truncate($communityTopic->getName(), 36)), '@communityTopic_show?id='.$communityTopic->getId()) ?>
    (<?php echo $communityTopic->getCommunity()->getName() ?>)
    </div>
  </div>
<?php endforeach; ?>
</div>
