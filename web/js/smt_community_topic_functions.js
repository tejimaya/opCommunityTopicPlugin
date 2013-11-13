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
    params.body = $('input#commentBody').val();
  }
  else if ('topic_comment_delete' == target) {
    params.id = $("#deleteCommentModal").attr('data-comment-id');
  }

  return params;
} //}}}

function getEntry(params) { //{{{
  var params = params || getParams('event_search');

  $('#loading').show();
  $.getJSON( openpne.apiBase + 'topic/search.json',
    params,
    function(json)
    {
      $('#show').html($('#topicEntry').tmpl(json.data));
      getComments();
    }
  );
} //}}}

function getComments(params) { //{{{
  var params = params || getParams('topic_comment_search');

  $.getJSON( openpne.apiBase + 'topic_comment/search.json',
    params,
    function(res)
    {
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
  );
} //}}}

function deleteTopic(params) { //{{{
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
} //}}}

function postTopicComment(params) { //{{{
  toggleSubmitState();
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

      $('#comments').prepend(postedComment);
      $('input#commentBody').val('');
    }
  )
  .error(
    function(res)
    {
      console.log(res);
    }
  )
  .complete(toggleSubmitState);
} //}}}

function deleteTopicComment(params) { //{{{
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
} //}}}

function toggleSubmitState() { //{{{
  $('input[name=submit]').toggle();
  $('.comment-form-loader').toggle();
} //}}}

// vim:sw=2 ts=2 et si fdm=marker:
