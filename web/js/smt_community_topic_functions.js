function getParams(target) { //{{{
  var params = {
    apiKey: openpne.apiKey,
  };

  if ('topic' == target) {
    params.target = 'topic';
    params.target_id = topic_id;
  }
  else if ('topic_delete' == target) {
    params.id = topic_id;
  }
  else if ('topic_comment_search' == target) {
    params.community_topic_id = topic_id;
  }
  else if ('topic_comment_post' == target) {
    params.community_topic_id = topic_id;
    params.body = $('#commentBody').val();
  }
  else if ('topic_comment_delete' == target) {
    params.id = $("#deleteCommentModal").attr('data-comment-id');
  }

  return params;
} //}}}

function getEntry(params) { //{{{
  var success = function (res) {
    $('#show').html( $('#topicEntry').tmpl(res.data) );
    getComments();
  };

  $('#loading').show();
  ajax({
    url: 'topic/search.json',
    data: params || getParams('topic_search'),
    success: success,
  });
} //}}}

function getComments(params) { //{{{
  var success = function (res) {
    if (0 == res.data.length)
    {
      $('#loadmore').hide();
    }
    else
    {
      comment_count += res.data.length;
      $('#loadmore').attr('x-since-id', res.data[0].id).show();
      res.data.reverse();
      var comments = $('#topicComment').tmpl(res.data,
      {
        calcTimeAgo: function(){
          return _timeAgo(this.data.created_at);
        }
      });
      $('#comments').append(comments);

      if (res.data_count - comment_count == 0)
      {
        $('#loadmore').hide();
      }
    }

    $('#loading').hide();
    comment_page++;
  }

  ajax({
    url: 'topic_comment/search.json',
    data: params || getParams('topic_comment_search'),
    success: success,
  });
} //}}}

function deleteTopic(params) { //{{{
  var success = function (res) {
    window.location = '/communityTopic/listCommunity/' + res.data.community_id;
  }

  ajax({
    url: 'topic/delete.json',
    type: 'POST',
    data: params,
    success: success,
  });
} //}}}

function postTopicComment(params) { //{{{
  toggleSubmitState();
  $('#comment-error').hide();

  var success = function (res) {
    $('#required').hide();
    var postedComment = $('#topicComment').tmpl(res.data,
      {
        calcTimeAgo: function(){
          return _timeAgo(this.data.created_at);
        }
      });

    $('#comments').prepend(postedComment);
    $('#commentBody').val('');
  }

  var error = function (res) {
    $('#comment-error').show();
    console.log(res);
  }

  ajax({
    url: 'topic_comment/post.json',
    data: params,
    type: 'POST',
    contentType: "application/json",
    success: success,
    error: error,
    complete: toggleSubmitState,
  });
} //}}}

function deleteTopicComment(params) { //{{{
  ajax({
    url: 'topic_comment/delete.json',
    type: 'POST',
    data: params,
    success: function(res) { $('#comment' + res.data.id).remove(); },
  });
} //}}}

function ajax(args) { //{{{
  $.ajax({
    url: openpne.apiBase + args.url,
    type: args.type || 'GET',
    data: args.data,
    dataType: 'json',
    success: args.success,
    error: args.error || function (res) { console.log(res); },
    complete: args.complete,
  });
} //}}}

function toggleSubmitState() { //{{{
  $('input[name=submit]').toggle();
  $('.comment-form-loader').toggle();
} //}}}

// vim:sw=2 ts=2 et si fdm=marker:
