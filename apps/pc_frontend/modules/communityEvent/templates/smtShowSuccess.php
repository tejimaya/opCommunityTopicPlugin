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
<script id="eventEntry" type="text/x-jquery-tmpl">
  <div class="row">
    <div class="gadget_header span12">イベント</div>
  </div>
  <div class="row">
    {{if editable}}
    <h3 class="span9">${name}</h3>
    <div class="btn-group span3">
      <a href="<?php echo public_path('communityEvent/edit')?>/${id}" class="btn"><i class="icon-pencil"></i></a>
      <a href="javascript:void(0)" class="btn" id="deleteEntry"><i class="icon-remove"></i></a>
    </div>
    {{else}}
    <h3 class="span12">${name}</h3>
    {{/if}}
  </div>
  <div class="row body">
    <div class="span12 body">{{html body}}</div>
  </div>
  <div class="row">
    <div class="span3">企画者</div><div class="span9"><a href="${member.profile_url}">${member.name}</a></div>
  </div>
  <div class="row">
    <div class="span3">開催日時</div><div class="span9">${open_date}</div>
  </div>
  <div class="row">
    <div class="span3">開催日時補足</div><div class="span9">${open_date_comment}</div>
  </div>
  <div class="row">
    <div class="span3">開催場所</div><div class="span9">${area}</div>
  </div>
  <div class="row">
    <div class="span3">募集期日</div><div class="span9">${application_deadline}</div>
  </div>
  <div class="row">
    <div class="span3">募集人数</div><div class="span9">{{if capacity}}${capacity}{{else}}0{{/if}}</div>
  </div>
  <div class="row">
  <div class="span3">参加人数</div><div class="span9" id="participants">${participants} {{if 0 < participants}}(<a href="${id}/memberList">参加者一覧</a>){{/if}}</div>
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
      <input class="event-comment-form-input" type="text" id="commentBody" />
      <div class="btn-toolbar">
        {{if is_event_member}}
          <button class=" btn btn-primary btn-mini comment-button " id="postCancel">参加をキャンセルする</button>
        {{else}}
          <button class=" btn btn-primary btn-mini comment-button " id="postJoin">このイベントに参加する</button>
        {{/if}}
        <button class=" btn btn-primary btn-mini comment-button " id="postComment">コメントのみ書き込む</button>
      </div>
      <div class="comment-form-loader">
        <?php echo op_image_tag('ajax-loader.gif', array()) ?>
      </div>
    </div>
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
      <!-- Like Plugin -->
      <div class="row like-wrapper" data-like-id="${id}" data-like-target="e" member-id="${member.id}" style="display: none;">
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
var event_id = <?php echo $id ?>;

function _timeAgo(created_at){
  return moment(created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
}

function getEntry(params)
{
  params = {} || params;
  params.target = 'event';
  params.target_id = event_id;
  params.apiKey = openpne.apiKey;

  $('#loading').show();
  $.getJSON( openpne.apiBase + 'event/search.json',
    params,
    function(json)
    {
      var entry = $('#eventEntry').tmpl(json.data);
      $('#show').html(entry);
      getComments();
    }
  );

}

function getComments(params){
  params = params || {};
  params.community_event_id = event_id;
  params.apiKey = openpne.apiKey;

  $.getJSON( openpne.apiBase + 'event_comment/search.json',
    params,
    function(res)
    {
      if (res.data.length === 0)
      {
        $('#loadmore').hide();
      }
      else
      {
        var comments = $('#eventComment').tmpl(res.data,
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
        id: event_id,
      };

      $.post(openpne.apiBase + "event/delete.json",
        params,
        'json'
      )
      .success(
        function(res)
        {
          window.location = '/communityEvent/listCommunity/' + res.data.community_id;
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
      community_event_id: event_id,
      body: $('input#commentBody').val()
    };

    $.post(openpne.apiBase + "event_comment/post.json",
      params,
      'json'
    )
    .success(
      function(res)
      {
        $('#required').hide();
        var postedComment = $('#eventComment').tmpl(res.data,
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

  $(document).on('click', '#postJoin',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }
    $('input[name=submit]').toggle();
    var params = {
      apiKey: openpne.apiKey,
      community_event_id: event_id,
      body: $('input#commentBody').val()
    };

    $.post(openpne.apiBase + "event_comment/post.json",
      params,
      'json'
    )
    .success(
      function(res)
      {
        $('#required').hide();
        var postedComment = $('#eventComment').tmpl(res.data,
                            {
                              calcTimeAgo: function(){
                                return _timeAgo(this.data.created_at);
                              }
                            });

        $('#comments').append(postedComment);
        $('input#commentBody').val('');

        var params = {
          apiKey: openpne.apiKey,
          id: event_id
        }
        $.post(openpne.apiBase + "event/join.json",
          params,
          'json'
        )
        .success(
          function(res_join)
          {
            getEntry();
          }
        )
        .error(
          function(res_join)
          {
            console.log(res_join);
          }
        )
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

  $(document).on('click', '#postCancel',function(){
    if (0 >= jQuery.trim($('input#commentBody').val()).length)
    {
      $('#required').show();
      return -1;
    }
    $('input[name=submit]').toggle();
    var params = {
      apiKey: openpne.apiKey,
      community_event_id: event_id,
      body: $('input#commentBody').val()
    };

    $.post(openpne.apiBase + "event_comment/post.json",
      params,
      'json'
    )
    .success(
      function(res)
      {
        $('#required').hide();
        var postedComment = $('#eventComment').tmpl(res.data,
                            {
                              calcTimeAgo: function(){
                                return _timeAgo(this.data.created_at);
                              }
                            });

        $('#comments').append(postedComment);
        $('input#commentBody').val('');

        var params = {
          apiKey: openpne.apiKey,
          id: event_id,
          leave: true
        }
        $.post(openpne.apiBase + "event/join.json",
          params,
          'json'
        )
        .success(
          function(res_join)
          {
            getEntry();
          }
        )
        .error(
          function(res_join)
          {
            console.log(res_join);
          }
        )
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

      $.post(openpne.apiBase + "event_comment/delete.json",
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
    <h5><?php echo __('Delete the event and comments');?></h5>
  </div>
  <div class="modal-body">
    <p class="center"><?php echo __('Do you really delete this event?');?></p>
  </div>
  <div class="modal-footer">
    <button class="btn modal-button" id="cancel"><?php echo __('Cancel ');?></button>
    <button class="btn btn-primary modal-button" id="execute"><?php echo __('Delete');?></button>
  </div>
</div>
