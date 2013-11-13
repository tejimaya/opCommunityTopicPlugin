<?php
use_helper('opAsset');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-modal.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-transition.js', 'last');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/functions.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/smt_community_topic_functions.js', 'last');
?>

<script id="topicEntry" type="text/x-jquery-tmpl">
  <div class="row">
    <div class="gadget_header span12">トピック</div>
  </div>
  <div class="row">
    {{if editable}}
      <h3 class="span9">${name}</h3>
      <div class="btn-group span3">
        <a href="<?php echo public_path('communityTopic/edit')?>/${id}" class="btn"><i class="icon-pencil"></i></a>
        <a href="javascript:void(0)" class="btn" id="deleteEntry"><i class="icon-remove"></i></a>
      </div>
    {{else}}
      <h3 class="span12">${name}</h3>
    {{/if}}
  </div>
  <div class="row body">
    <div class="span12">{{html body}}</div>
  </div>
  <div class="row images center">
    {{each images}}
      <div class="span4"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
    {{/each}}
  </div>
  <div class="row">
    <div class="gadget_header">コメント</div>
  </div>
  <div class="row" id="commentForm">
    {{if isCommentCreatable }}
      <div class="comment-wrapper">
        <div id="required" class="hide"><?php echo __('Required.') ?></div>
        <divclass="comment-form">
        <input class="comment-form-input" type="text" id="commentBody" />
        <input type="submit" name="submit" class="btn btn-primary btn-mini comment-button " id="postComment" value="コメント投稿">
        </div>
        <div class="comment-form-loader">
          <?php echo op_image_tag('ajax-loader.gif', array()) ?>
        </div>
      </div>
    {{/if}}
  </div>
  <div class="row comments" id="comments">
  </div>
  <div class="row">
    <button class="span12 btn small hide" id="loadmore"><?php echo __('More'); ?></button>
  </div>
</script>

<script id="topicComment" type="text/x-jquery-tmpl">
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
var topic_id = <?php echo $id ?>;
var comment_count = 0;
var comment_page = 1;
var isCommentCreatable = <?php echo (int)$isCommentCreatable ?>

$(function(){

  getEntry( getParams('topic') );

  $(document).on('click', '#loadmore', function()
  {
    var params = getParams('topic_comment_search');
    params.page = comment_page;
    getComments( params );
  });

  $(document).on('click', '#deleteEntry', function(e){
    $('#deleteEntryModal').on('shown', function(e){
        showModal($(this));
        return this;
      })
      .modal('show');

    e.preventDefault();
    return false;
  });

  $('#deleteEntryModal .modal-button').click(function(e){
    if(e.target.id == 'execute')
    {
      deleteTopic( getParams('topic_delete') );
    }
    else
    {
      $('#deleteEntryModal').modal('hide');
    };
  });

  $(document).on('click', '#postComment',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postTopicComment(getParams('topic_comment_post'));
  });

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
      deleteTopicComment( getParams('topic_comment_delete') );
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

<div class="modal hide" id="deleteEntryModal">
  <div class="modal-header">
    <h5><?php echo __('Delete the topic and comments');?></h5>
  </div>
  <div class="modal-body">
    <p class="center"><?php echo __('Do you really delete this topic?');?></p>
  </div>
  <div class="modal-footer">
    <button class="btn modal-button" id="cancel"><?php echo __('Cancel ');?></button>
    <button class="btn btn-primary modal-button" id="execute"><?php echo __('Delete');?></button>
  </div>
</div>
<!-- Modal end -->

<ul class="footer">
  <li>
    <a href="<?php echo public_path('communityTopic/listCommunity').'/'.$community->getId() ?>"><?php echo __('List of topics') ?></a>
  </li>
  <li>
    <a href="<?php echo public_path('community').'/'.$community->getId() ?>"><?php echo __('%Community% Top Page') ?></a>
  </li>
</ul>
