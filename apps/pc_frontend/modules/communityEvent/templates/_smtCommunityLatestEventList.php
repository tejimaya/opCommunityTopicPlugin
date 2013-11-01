<?php
use_helper('Javascript', 'opUtil', 'opAsset');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/gadget.js', 'last');
?>
<script id="eventEntry" type="text/x-jquery-tmpl">
<div class="row">
  <div class="span3">${$item.calcTimeAgo()}</div>
  <div class="span9"><a href="<?php echo public_path('communityEvent')?>/${id}">${name}</a> (${community_name})</div>
</div>
</script>

<script type="text/javascript">
$(function(){
  var params = {
    apiKey: openpne.apiKey,
    format: 'mini',
    target: 'community',
    target_id: <?php echo $communityId ?>,
    count: 4
  }

  gadget.search(params, 'event');
})
</script>

<hr class="toumei" />
<div class="row">
  <div class="gadget_header span12">イベント一覧</div>
</div>
<hr class="toumei" />
<div id="eventList" style="margin-left: 0px;">
</div>

<div class="row hide" id="eventreadmore">
<a href="<?php echo public_path('communityEvent/listCommunity').'/'.$communityId ?>" class="btn btn-block span11"><?php echo __('More')?></a>
</div>
