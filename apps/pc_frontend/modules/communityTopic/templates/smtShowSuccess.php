<?php
use_helper('opAsset');
//op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-modal.js', 'last');
//op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-transition.js', 'last');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
?>
<script id="topicEntry" type="text/x-jquery-tmpl">
  <div class="row">
    <div class="gadget_header span12">トピック</div>
  </div>
  <div class="row">
    {{if editable}}
    <h3 class="span9">${name}</h3>
    <div class="btn-group span3">
      <a href="/communityTopic/edit/${id}" class="btn"><i class="icon-pencil"></i></a>
      <a href="javascript:void(0)" class="btn" id="deleteEntry"><i class="icon-remove"></i></a>
    </div>
    {{else}}
    <h3 class="span12">${name}</h3>
    {{/if}}
  </div>
  <div class="row body">
    <div class="span12">{{html body}}</div>
  </div>
  <div class="row images">
    {{each images}}
      <div class="span4"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
    {{/each}}
  </div>
  <div class="row" id="comments">
  </div>
  <div class="row" id="commentForm">
    <div class="span1">
    &nbsp;
    </div>
    <textarea id="commentBody"></textarea>
    <input type="submit" class="btn" id="postComment" value="投稿">
  </div>
</script>

<script id="topicComment" type="text/x-jquery-tmpl">
  <div class="row" id="comment${id}">
    <div class="span1">
      &nbsp;
    </div>
    <div class="span3">
      <a href="${member.profile_url}"><img src="${member.profile_image}" class="rad10" width="57" height="57"></a>
    </div>
    <div class="span8">
      <div>
        <a href="${member.profile_url}">{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}</a>
        {{html body}}
      </div>
      <div class="row">
        <span>${ago}</span>
        {{if deletable}}
        <a href="javascript:void(0);" class="deleteComment" data-comment-id="${id}"><i class="icon-remove"></i></a>
        {{/if}}
      </div>
      <div class="images center">
        {{each images}}
          <div class="span2"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
        {{/each}}
      </div>
    </div>
  </div>
</script>

<script type="text/javascript">
var topic_id = <?php echo $id ?>;

function getEntry(params)
{
  params.id = topic_id;
  $('#loading').show();
  $.getJSON( openpne.apiBase + 'topic/search.json',
    params,
    function(json)
    {
      var entry = $('#topicEntry').tmpl(json.data);
      $('#show').html(entry);

      var params = {
        apiKey: openpne.apiKey,
        community_topic_id: topic_id
      }
      $.getJSON( openpne.apiBase + 'topic_comment/search.json',
        params,
        function(res)
        {
          var comments = $('#topicComment').tmpl(res.data.comments);
          $('#comments').html(comments);
          $('#loading').hide();
        }
      );

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
  getEntry({apiKey: openpne.apiKey});

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
    $('input[name=submit]').toggle();
    var params = {
      apiKey: openpne.apiKey,
      community_topic_id: topic_id,
      body: $('textarea#commentBody').val()
    };

    $.post(openpne.apiBase + "topic_comment/post.json",
      params,
      'json'
    )
    .success(
      function(res)
      {
        $('#comments').append($('#topicComment').tmpl(res.data));
        $('textarea#commentBody').val('');
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
    <button class="btn modal-button" id="cancel"><?php echo __('Cancel');?></button>
    <button class="btn btn-primary modal-button" id="execute"><?php echo __('Delete');?></button>
  </div>
</div>

<div class="modal hide" id="deleteEntryModal">
  <div class="modal-header">
    <h5><?php echo __('Delete the diary');?></h5>
  </div>
  <div class="modal-body">
    <p class="center"><?php echo __('Do you really delete this diary?');?></p>
  </div>
  <div class="modal-footer">
    <button class="btn modal-button" id="cancel"><?php echo __('Cancel');?></button>
    <button class="btn btn-primary modal-button" id="execute"><?php echo __('Delete');?></button>
  </div>
</div>
