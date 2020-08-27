<?php
use_helper('Javascript', 'opUtil', 'opAsset');
?>
<hr class="toumei" />
<div class="row">
  <div class="gadget_header span12"><?php echo __('List of %Community% events to which the members belong') ?></div>
</div>
<hr class="toumei" />
<div id="eventList" style="margin-left: 0px;">
<?php foreach ($communityEvents as $key => $communityEvent): ?>
  <div class="row">
    <div class="span3">
      <?php echo op_format_date($communityEvent->getUpdatedAt(), 'XShortDateJa'); ?>
    </div>
    <div class="span9">
    <?php echo link_to(sprintf('%s', op_truncate($communityEvent->getName(), 36)), '@communityEvent_show?id='.$communityEvent->getId()) ?>
    (<?php echo $communityEvent->getCommunity()->getName() ?>)
    </div>
  </div>
<?php endforeach; ?>
</div>
