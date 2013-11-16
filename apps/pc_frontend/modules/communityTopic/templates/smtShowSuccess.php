<?php
use_helper('opAsset');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-transition.js', 'last');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/functions.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/smt_community_topic_functions.js', 'last');
?>

<script id="topicEntry" type="text/x-jquery-tmpl">
  <!-- //topic -->
  <div id="topic">
    <div class="row">
      <div class="gadget_header span12"><?php echo __('Topic') ?></div>
    </div>
    <div class="row topic_information">
      <div class="row title">
        <h3 class="span9">${name}</h3>
        {{if editable}}
          <div class="btn-group span3">
            <a href="<?php echo public_path('communityTopic/edit')?>/${id}" class="btn"><i class="icon-pencil"></i></a>
            <a href="javascript:void(0)" class="btn" id="deleteEntry"><i class="icon-remove"></i></a>
          </div>
        {{/if}}
      </div>
      <div class="row author">
        <div class="span12">
          <a href="${member.profile_url}">${member.screen_name}</a>
        </div>
      </div>
      <div class="row body">
        <div class="span12">{{html body}}</div>
      </div>
      <div class="row images center">
        {{each images}}
          <div class="span4"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
        {{/each}}
      </div>
    </div>
  </div>
  <!-- //topic end -->
  <!-- //comment -->
  <div id="comment">
    <div class="row">
      <div class="gadget_header"><?php echo __('Comment') ?></div>
    </div>
    <!-- //comment form -->
    <div class="row" id="commentForm">
      {{if isCommentCreatable }}
        <div class="comment-wrapper">
          <div id="required" class="hide"><?php echo __('Required.') ?></div>
          <div id="comment-error" class="hide"><?php echo '投稿に失敗しました。' ?></div>
          <div class="comment-form">
            <input class="comment-form-input" type="text" id="commentBody" />
            <input type="submit" name="submit" class="btn btn-primary btn-mini comment-button " id="postComment" value="<?php echo __('Post a new topic comment') ?>">
          </div>
          <div class="comment-form-loader">
            <?php echo op_image_tag('ajax-loader.gif', array()) ?>
          </div>
        </div>
      {{/if}}
    </div>
    <!-- //comment form end -->
    <div class="row comments" id="comments">
    </div>
    <div class="row">
      <button class="span12 btn small hide" id="loadmore"><?php echo __('More'); ?></button>
    </div>
  </div>
  <!-- //comment end -->
</script>

<?php include_partial('communityTopic/smtCommentBox', array('target' => 'topic')) ?>

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

  $('#deleteEntryModal .modal-button').click(function(e){
    if(e.target.id == 'execute')
    {
      deleteTopic( getParams('topic_delete') );
    }

    $('#deleteEntryModal').modal('hide');
  });

  $(document).on('click', '#postComment',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }

    postTopicComment(getParams('topic_comment_post'));
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
<?php include_partial('communityTopic/modal', array('target' => 'topic')) ?>

<ul class="footer">
  <li>
    <?php echo link_to(__('List of topics'), '@communityTopic_list_community?id='.$community->getId()) ?>
  </li>
  <li>
    <?php echo link_to(__('%Community% Top Page'), '@community_home?id='.$community->getId()) ?>
  </li>
</ul>
