<?php
use_helper('opAsset');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-modal.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-transition.js', 'last');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
op_smt_use_stylesheet('/opLikePlugin/css/like-smartphone.css', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/moment.min.js', 'last');
op_smt_use_javascript('/opCommunityTopicPlugin/js/lang/ja.js', 'last');
op_smt_use_javascript('/opLikePlugin/js/like-smartphone.js', 'last');
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
    <button class="span12 btn small hide" id="loadmore"><?php echo __('More'); ?></button>
  </div>
  <div class="row comments" id="comments">
  </div>
  <div class="row" id="commentForm">
          <div class="comment-wrapper">
            <div id="required" class="hide"><?php echo __('Required.') ?></div>
            <divclass="comment-form">
            <input class="comment-form-input" type="text" id="commentBody" /><input type="submit" class="btn btn-primary btn-mini comment-button " id="postComment" value="投稿">
            </div>
            <div class="comment-form-loader">
              <?php echo op_image_tag('ajax-loader.gif', array()) ?>
            </div>
          </div>
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
      <!-- Like Plugin -->
      <div class="row like-wrapper" data-like-id="${id}" data-like-target="t" member-id="${member.id}" style="display: none;">
      <span class="span6"> 
      <a class="like-post">いいね！</a>
      <a class="like-cancel">いいね！を取り消す</a>
      </span>
      <span class="span4">
      <a class="like-list"></a>
      </span>
      </div>
    </div>
  </div>
</script>

<script type="text/javascript">
var topic_id = <?php echo $id ?>;

function _timeAgo(created_at){
  return moment(created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
}

function getEntry(params)
{
  params = {} || params;
  params.target = 'topic';
  params.target_id = topic_id;
  params.apiKey = openpne.apiKey;

  $('#loading').show();
  $.getJSON( openpne.apiBase + 'topic/search.json',
    params,
    function(json)
    {
      var entry = $('#topicEntry').tmpl(json.data);
      $('#show').html(entry);
      getComments();
    }
  );

}

function getComments(params){
  params = params || {};
  params.community_topic_id = topic_id;
  params.apiKey = openpne.apiKey;

      $.getJSON( openpne.apiBase + 'topic_comment/search.json',
        params,
        function(res)
        {
          if (res.data.length === 0)
          {
            $('#loadmore').hide();
          }
          else
          {
            var comments = $('#topicComment').tmpl(res.data,
                            {
                              calcTimeAgo: function(){
                                return _timeAgo(this.data.created_at);
                              }
                            });
            $('#comments').prepend(comments);
            $('#loadmore').attr('x-since-id', res.data[res.data.length-1].id).show();
          }
          $('#loading').hide();
        }
      );

}

function showModal(modal){
  var windowHeight = window.outerHeight > $(window).height() ? window.outerHeight : $(window).height();
  $('.modal-backdrop').css({'position': 'absolute','top': '0', 'height': windowHeight});

  var scrollY = window.scrollY;
  var viewHeight = window.innerHeight ? window.innerHeight : $(window).height();
  var modalTop = scrollY + ((viewHeight - modal.height()) / 2 );

  modal.css('top', modalTop);
}

$(function(){
  getEntry();

  $(document).on('click', '#loadmore', function()
  {
    var params = {
      since_id: $(this).attr('x-since-id')
    };
    getComments(params);
  })

  $(document).on('click', '#deleteEntry', function(e){
    $('#deleteEntryModal')
      .on('shown', function(e)
      {
        showModal($(this));
        return this;
      })
      .modal('show');

    e.preventDefault();
    return false;
  })

  $('#deleteEntryModal .modal-button').click(function(e){
    if(e.target.id == 'execute')
    {
      var params = {
        apiKey: openpne.apiKey,
        id: topic_id,
      };

      $.post(openpne.apiBase + "topic/delete.json",
        params,
        'json'
      )
      .success(
        function(res)
        {
          window.location = '/communityTopic/listCommunity/' + res.data.community_id;
        }
      )
      .error(
        function(res)
        {
          console.log(res);
        }
      )
    }
    else
    {
      $('#deleteEntryModal').modal('hide');
    };
  })

  $(document).on('click', '#postComment',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }
    $('input[name=submit]').toggle();
    var params = {
      apiKey: openpne.apiKey,
      community_topic_id: topic_id,
      body: $('input#commentBody').val()
    };

    $.post(openpne.apiBase + "topic_comment/post.json",
      params,
      'json'
    )
    .success(
      function(res)
      {
        $('#required').hide();
        var postedComment = $('#topicComment').tmpl(res.data,
                            {
                              calcTimeAgo: function(){
                                return _timeAgo(this.data.created_at);
                              }
                            });

        $('#comments').append(postedComment);
        $('input#commentBody').val('');
      }
    )
    .error(
      function(res)
      {
        console.log(res);
      }
    )
    .complete(
      function(res)
      {
        $('input[name=submit]').toggle();
      }
    );
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
      var params = {
        apiKey: openpne.apiKey,
        id: $("#deleteCommentModal").attr('data-comment-id'),
      };

      $.post(openpne.apiBase + "topic_comment/delete.json",
        params,
        'json'
      )
      .success(
        function(res)
        {
          $('#comment'+res.data.id).remove();
        }
      )
      .error(
        function(res)
        {
          console.log(res);
        }
      )
      .complete(
        function(res)
        {
          $('#deleteCommentModal').attr('data-comment-id', '').modal('hide');
        }
      );
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
