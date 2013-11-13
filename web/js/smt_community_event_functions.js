function getParams(target) { //{{{
  var params = {
    apiKey: openpne.apiKey,
  };

  if ('event_search' == target) {
    params.target = 'event';
    params.target_id = event_id;
  }
  else if ('event_join' == target) {
    params.id = event_id;
  }
  else if ('event_join_leave' == target) {
    params.id = event_id;
    params.leave = true;
  }
  else if ('event_comment_search' == target) {
    params.community_event_id = event_id;
  }
  else if ('event_comment_post' == target) {
    params.community_event_id = event_id;
    params.body = $('input#commentBody').val();
  }
  else if ('event_comment_delete' == target) {
    params.id = $("#deleteCommentModal").attr('data-comment-id');
  }

  return params;
} //}}}

function getEntry(params) //{{{
{
  var params = params || getParams('event_search');

  $('#loading').show();
  $.getJSON( openpne.apiBase + 'event/search.json',
    params,
    function(json)
    {
      $('#show').html( $('#eventEntry').tmpl(json.data) );
      getComments();
    }
  );
} //}}}

function getComments(params){ //{{{
  var params = params || getParams('event_comment_search');

  $.getJSON( openpne.apiBase + 'event_comment/search.json',
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
        var comments = $('#eventComment').tmpl(res.data,
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
      comment_page++
    }
  );
} //}}}

function postEventComment(params) { //{{{
  toggleSubmitState();
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

function postEventJoin(params) { //{{{
  $.post(openpne.apiBase + "event/join.json",
    params,
    'json'
  )
  .success(
    function(res)
    {
      postEventComment( getParams('event_comment_post') );

      if (res.data[0].participants) {
        $('#participants').html(res.data[0].participants + '(<a href="${id}/memberList">参加者一覧</a>)')
      }
      else {
        $('#participants').html(res.data[0].participants);
      }

      if (!res.data[0].is_event_member) {
        $('#postCancel').attr({id: 'postJoin'}).html('このイベントに参加する');
      }
      else {
        $('#postJoin').attr({id: 'postCancel'}).html('参加をキャンセルする');
      }
    }
  )
  .error(
    function(res)
    {
      console.log(res);
    }
  )
} //}}}

function deleteComment(params) { //{{{
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
} //}}}

function toggleSubmitState() { //{{{
  $('.comment-button').toggle();
  $('.comment-form-loader').toggle();
} //}}}

// vim:sw=2 ts=2 et si fdm=marker:
