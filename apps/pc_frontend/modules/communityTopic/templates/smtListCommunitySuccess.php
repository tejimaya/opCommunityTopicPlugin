<?php
use_helper('opAsset');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
?>
<script id="topicEntry" type="text/x-jquery-tmpl">
<div class="row entry">
  <span class="span3">
    ${$item.calcTimeAgo()}
  </span>
  <span class="span9"><a href="<?php echo public_path('communityTopic'); ?>/${id}">${name}</a>（${community_name}）</span>
  <div class="span12">
    <div>
      {{if latest_comment}}
        {{html $item.truncateComment()}}
        <a href="<?php echo public_path('communityTopic'); ?>/${id}#${latest_comment_id}" class="readmore">続き</a>
      {{else}}
        <span class="muted">（まだコメントはありません）</span>
      {{/if}}
    </div>
    <div class="clearfix"></div>
  </div>
</div>
</script>

<script type="text/javascript">
function getList(params)
{
  var dataLength = $('#list').children().length;
  var id = <?php echo $id ?>;
  params.target = 'community';
  params.format = 'mini';
  params.target_id = id;
  $('#loading').show();
  $.getJSON( openpne.apiBase + 'topic/search.json',
    params,
    function(json)
    {
      if (json.data.length === 0 || dataLength === json.data.length)
      {
        $('#noEntry').show();
        $('#loadmore').hide();
      }
      else
      {
        var entry = $('#topicEntry').tmpl(json.data, 
        {
          truncateComment: function(){
            return this.data.latest_comment.substr(0, 50);
          },
          calcTimeAgo: function(){
            return moment(this.data.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
          }
        });
        $('#list').children().remove();
        $('#list').append(entry);
        $('#loadmore').attr('data-length', json.data.length).show();
      }
      $('#loading').hide();
    }
  );
}

$(function(){
  getList({apiKey: openpne.apiKey});

  $('#loadmore').click(function()
  {
    var params = {
      apiKey: openpne.apiKey,
      count: parseInt($(this).attr('data-length')) + 15
    };
    getList(params);
  })
})
</script>
<div class="row">
  <a href="<?php echo public_path('communityTopic/new').'/'.$id ?>" class="btn span11"><?php echo __('Create a new topic');?></a>
</div>
<hr class="toumei"/>
<div class="row">
  <div class="gadget_header span12"><?php echo __('List of topics of this community'); ?></div>
</div>
<div id="list"></div>
<div class="row hide" id="noEntry">
  <div class="center span12">トピックはありません</div>
</div>
<div class="row">
  <div id="loading" class="center">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
</div>
<div class="row">
  <button class="span12 btn small hide" id="loadmore"><?php echo __('More'); ?></button>
</div>

