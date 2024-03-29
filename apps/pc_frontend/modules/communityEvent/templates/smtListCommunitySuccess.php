<?php
use_helper('opAsset');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
?>
<script id="eventEntry" type="text/x-jquery-tmpl">
<div class="row entry">
  <span class="span3">
    ${$item.calcTimeAgo()}
  </span>
  <span class="span9"><a href="<?php echo public_path('communityEvent'); ?>/${id}">${name}</a></span>
  <div class="span12">
    <div>
      <div class="event-comment-list" eventId="${id}"></div>
      {{if latest_comment}}
        {{html $item.truncateComment()}}
      {{else}}
        <span class="muted">（まだコメントはありません）</span>
      {{/if}}
    </div>
    <div class="clearfix"></div>
  </div>
</div>
</script>

<script id="eventComments" type="text/x-jquery-tmpl">
<div class="event-comment"></div>
</script>

<script type="text/javascript">
var count = 0;
function getList(params)
{
  $('#loading').show();
  $.getJSON( openpne.apiBase + 'event/search.json',
    params,
    function(json)
    {
      if (json.data.length === 0)
      {
        $('#noEntry').show();
        $('#loadmore').hide();
      }
      else
      {
        var entry = $('#eventEntry').tmpl(json.data,
        {
          truncateComment: function(){
            return this.data.latest_comment.substr(0, 50);
          },
          calcTimeAgo: function(){
            return moment(this.data.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
          }
        });
        $('#list').append(entry);
        count += json.data.length;
        if (count < json.data_count)
        {
          $('#loadmore').show();
        }
        else
        {
          $('#loadmore').hide();
        }
      }
      $('#loading').hide();
    }
  );
}

function getComments()
{
  $('.event-comment-list').each(function()
  {
    var id = $(this).attr(eventId);
    var params = {
      community_event_id: id,
      count: 2
    }
    $.getJSON(openpne.apiBase + 'event_comment/search.json',
      params,
      function(comments)
      {
        var commentList = $('#eventComments').tmpl(comments);
        $('div[class="event-comment-list"][eventId="' + id + '"]').append(commentList);
      }
    );
  });

}

$(function(){
  var params = {
    apiKey: openpne.apiKey,
    target: 'community',
    format: 'mini',
    target_id: <?php echo $id ?>,
  }
  getList(params);

  $('#loadmore').click(function()
  {
    if (!params.page)
    {
      params.page = 2;
    }
    else
    {
      params.page++;
    }
    getList(params);
  })
})
</script>

<?php if ($isEventCreatable): ?>
  <div class="row">
    <a href="<?php echo public_path('communityEvent/new').'/'.$id ?>" class="btn span11"><?php echo __('Create a new event');?></a>
  </div>
<?php endif; ?>
<hr class="toumei"/>
<div class="row">
  <div class="gadget_header span12"><?php echo __('List of events of this %Community%'); ?></div>
</div>
<div id="list"></div>
<div class="row hide" id="noEntry">
  <div class="center span12">イベントはありません</div>
</div>
<div class="row">
  <div id="loading" class="center">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
</div>
<div class="row">
  <button class="span12 btn small hide" id="loadmore"><?php echo __('More'); ?></button>
</div>

<ul class="footer">
  <li>
    <a href="<?php echo public_path('community').'/'.$community->getId() ?>"><?php echo __('%Community% Top Page') ?></a>
  </li>
</ul>
