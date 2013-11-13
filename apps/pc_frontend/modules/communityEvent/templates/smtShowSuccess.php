<?php
use_helper('opAsset');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-modal.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-transition.js', 'last');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/functions.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/smt_community_event_functions.js', 'last');
?>
<script id="eventEntry" type="text/x-jquery-tmpl">
  <!-- //event information -->
  <div class="row">
    <div class="gadget_header span12">イベント</div>
  </div>
  <div class="row">
    <h3 class="span12">${name}</h3>
  </div>
  <div class="row body">
    <div class="span12 body">{{html body}}</div>
  </div>
  <div class="row">
    <div class="span3">企画者</div><div class="span9"><a href="${member.profile_url}">${member.name}</a></div>
  </div>
  <div class="row">
    <div class="span3">開催日時</div><div class="span9">${open_date} ${open_date_comment}</div>
  </div>
  <div class="row">
    <div class="span3">開催場所</div><div class="span9">${area}</div>
  </div>
  <div class="row">
    <div class="span3">募集期日</div><div class="span9">${application_deadline}</div>
  </div>
  <div class="row">
    <div class="span3">募集人数</div><div class="span9">${capacity}</div>
  </div>
  <div class="row">
  <div class="span3">参加人数</div><div class="span9" id="participants">${participants} {{if 0 < participants}}(<a href="${id}/memberList">参加者一覧</a>){{/if}}</div>
  </div>
  <div class="row images center">
    {{each images}}
      <div class="span4"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
    {{/each}}
  </div>
  <!-- //end event information -->
  <div class="row">
    <div class="gadget_header">コメント</div>
  </div>
  <!-- //commetn form -->
  <div class="row" id="commentForm">
    {{if isCommentCreatable }}
      <div class="comment-wrapper">
      <div id="required" class="hide"><?php echo __('Required.') ?></div>
      <div id="comment-error" class="hide"><?php echo '投稿に失敗しました。' ?></div>
        <input class="event-comment-form-input" type="text" id="commentBody" />
        <div class="btn-toolbar">
          {{if is_event_member}}
            <button class="btn btn-primary btn-mini comment-button " id="postCancel">参加をキャンセルする</button>
          {{else}}
            {{if !capacity}}
              <button class="btn btn-primary btn-mini comment-button " id="postJoin">このイベントに参加する</button>
            {{else}}
              {{if capacity - participants > 0}}
                <button class="btn btn-primary btn-mini comment-button " id="postJoin">このイベントに参加する</button>
              {{/if}}
            {{/if}}
          {{/if}}
          <button class="btn btn-primary btn-mini comment-button " id="postComment">コメントのみ書き込む</button>
        </div>
        <div class="comment-form-loader">
          <?php echo op_image_tag('ajax-loader.gif', array()) ?>
        </div>
      </div>
    {{/if}}
  </div>
  <!-- //commetn form end -->
  <div class="row comments" id="comments">
  </div>
  <div class="row">
    <button class="span12 btn small hide" id="loadmore"><?php echo __('More'); ?></button>
  </div>
</script>

<script id="eventComment" type="text/x-jquery-tmpl">
  <div class="row" id="comment${id}">
    <div class="span11 comment-wrapper">
      <div class="comment-member-image">
        <a href="${member.profile_url}"><img src="${member.profile_image}" alt="{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}" width="23" /></a>
      </div>
      <div class="comment-content">
        <div class="comment-name-and-body">
        <a href="${member.profile_url}">{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}</a>
        <span class="comment-body">
          {{html body}}
        </span>
        </div>
        {{if images}}
          <div class="row">
            <div class="span11 images center">
              {{each images}}
                <div class="span2"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
              {{/each}}
            </div>
          </div>
        {{/if}}
      </div>
      <div class="comment-control row">
        <span>${$item.calcTimeAgo()}</span>
        {{if deletable}}
          <a href="javascript:void(0);" class="deleteComment" data-comment-id="${id}"><i class="icon-remove"></i></a>
        {{/if}}
      </div>
    </div>
  </div>
</script>

<script type="text/javascript">
var event_id = <?php echo $id ?>;
var comment_count = 0;
var comment_page = 1;
var isCommentCreatable = <?php echo (int)$isCommentCreatable ?>;

$(function(){

  getEntry();

  $(document).on('click', '#loadmore', function()
  {
    var params = getParams('event_comment_search');
    params.page = comment_page;
    getComments(params);
  })

  $(document).on('click', '#postComment',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postEventComment( getParams('event_comment_post') );
  })

  $(document).on('click', '#postJoin',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postEventJoin( getParams('event_join') );
  })

  $(document).on('click', '#postCancel',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postEventJoin( getParams('event_join_leave') );
  })

  $(document).on('click', '.deleteComment',function(e){
    $('#deleteCommentModal')
      .attr('data-comment-id', $(this).attr('data-comment-id'))
      .on('shown', function(e)
      {
        showModal($(this));
        return this;
      })
      .modal('show');
    e.preventDefault();

    return false;
  });

  $('#deleteCommentModal .modal-button').click(function(e){
    if(e.target.id == 'execute')
    {
      deleteComment( getParams('event_comment_delete') );
    }
    else
    {
      $('#deleteCommentModal').attr('data-comment-id', '').modal('hide');
    };
  });

})

</script>
<div class="row">
  <div id="show"></div>
</div>
<div class="row">
  <div id="loading" class="center">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
</div>

<!-- Modal -->
<div class="modal hide" id="deleteCommentModal">
  <div class="modal-header">
    <h5><?php echo __('Delete the comment');?></h5>
  </div>
  <div class="modal-body">
    <p class="center"><?php echo __('Do you really delete this comment?');?></p>
  </div>
  <div class="modal-footer">
    <button class="btn modal-button" id="cancel"><?php echo __('Cancel ');?></button>
    <button class="btn btn-primary modal-button" id="execute"><?php echo __('Delete');?></button>
  </div>
</div>
<!-- Modal end -->

<ul class="footer">
  <li>
    <a href="<?php echo public_path('communityEvent/listCommunity').'/'.$community->getId() ?>"><?php echo __('List of events') ?></a>
  </li>
  <li>
    <a href="<?php echo public_path('community').'/'.$community->getId() ?>"><?php echo __('%Community% Top Page') ?></a>
  </li>
</ul>
