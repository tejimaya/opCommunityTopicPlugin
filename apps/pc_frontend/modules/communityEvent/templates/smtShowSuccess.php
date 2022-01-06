<?php
use_helper('opAsset');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-transition.js', 'last');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/functions.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/smt_community_event_functions.js', 'last');
?>
<script id="eventEntry" type="text/x-jquery-tmpl">
  <!-- //event -->
  <div id="event">
    <div class="row">
      <div class="gadget_header span12"><?php echo __('Event') ?></div>
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
      <div class="span3">開催日時</div><div class="span9">${$item.getJaDate( open_date )} ${open_date_comment}</div>
    </div>
    <div class="row">
      <div class="span3">開催場所</div><div class="span9">{{html area}}</div>
    </div>
    <div class="row">
      <div class="span3">募集期日</div>
      <div class="span9">
      {{if application_deadline}}${$item.getJaDate( application_deadline )}{{/if}}
      </div>
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
  </div>
  <!-- //event end -->
  <!-- //comment -->
  <div id="comment">
    <div class="row">
      <div class="gadget_header"><?php echo __('Comment') ?></div>
    </div>
    <!-- //commetn form -->
    <div class="row" id="commentForm">
      {{if isCommentCreatable }}
        <div class="comment-wrapper">
          <div id="required" class="hide"><?php echo __('Required.') ?></div>
          <div id="comment-error" class="hide"><?php echo '投稿に失敗しました。' ?></div>
          <textarea name="commentBody" id="commentBody" class="comment-form-input" style="width: 90%;" cols="35" rows="7"></textarea>
          <div class="btn-toolbar">
            {{if is_event_member}}
              <button class="btn btn-primary btn-mini comment-button " id="postCancel"><?php echo __('Cancel to join') ?></button>
            {{else}}
              {{if !application_deadline || $item.isStillApply( application_deadline )}}
                {{if !capacity || capacity - participants > 0}}
                  <button class="btn btn-primary btn-mini comment-button " id="postJoin"><?php echo __('Participate in this event') ?></button>
                {{/if}}
              {{/if}}
            {{/if}}
            <button class="btn btn-primary btn-mini comment-button " id="postComment"><?php echo __('Add a comment only') ?></button>
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
  </div>
  <!-- //comment end -->
</script>

<?php include_partial('communityTopic/smtCommentBox', array('target' => 'event')) ?>

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
    if (0 >= jQuery.trim($('#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postEventComment( getParams('event_comment_post') );
  })

  $(document).on('click', '#postJoin',function(){
    if (0 >= jQuery.trim($('#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postEventJoin( getParams('event_join') );
  })

  $(document).on('click', '#postCancel',function(){
    if (0 >= jQuery.trim($('#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postEventJoin( getParams('event_join_leave') );
  })

  $('#deleteCommentModal .modal-button').click(function(e){
    if(e.target.id == 'execute')
    {
      deleteComment( getParams('event_comment_delete') );
    }

    $('#deleteCommentModal').attr('data-comment-id', '').modal('hide');
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
<?php include_partial('communityTopic/modal', array('target', 'event')) ?>

<ul class="footer">
  <li>
    <?php echo link_to(__('List of events'), '@communityEvent_list_community?id='.$community->getId()) ?>
  </li>
  <li>
    <?php echo link_to(__('%Community% Top Page'), '@community_home?id='.$community->getId()) ?>
  </li>
</ul>
