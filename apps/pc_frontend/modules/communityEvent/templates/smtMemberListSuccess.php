<?php use_helper('Javascript') ?>
<script id="communityEventMemberJoinListTemplate" type="text/x-jquery-tmpl">
  <div class="span3">
    <div class="row_memberimg row"><div class="span3 center"><a href="${profile_url}"><img src="${profile_image}" class="rad10" width="57" height="57"></a></div></div>
    <div class="row_membername font10 row"><div class="span3 center"><a href="${profile_url}">${name}</a> (${friends_count})</div></div>
  </div>
</script>
<script type="text/javascript">
$(function(){
  $.getJSON( openpne.apiBase + 'event/member_list.json?id=<?php echo $communityEvent->getId() ?>&apiKey=' + openpne.apiKey, function(json) {
    $('#communityEventMemberJoinListTemplate').tmpl(json.data).appendTo('#communityEventMemberJoinList');
    $('#communityEventMemberJoinList').show();
    $('#communityEventMemberJoinListLoading').hide();
  });
});
</script>

<hr class="toumei" />
<div class="row">
  <div class="gadget_header span12"><?php echo __('Event Members') ?></div>
</div>
<hr class="toumei" />
<div class="row hide" id="communityEventMemberJoinList">
</div>
<div class="row center" id="communityEventMemberJoinListLoading" style="margin-left: 0;">
<?php echo op_image_tag('ajax-loader.gif') ?>
</div>
