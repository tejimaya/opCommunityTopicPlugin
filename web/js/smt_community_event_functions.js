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
  else if ('event_delete' == target) {
    params.id = event_id;
  }
  else if ('event_comment_search' == target) {
    params.community_event_id = event_id;
  }
  else if ('event_comment_post' == target) {
    params.community_event_id = event_id;
    params.body = $('#commentBody').val();
  }
  else if ('event_comment_delete' == target) {
    params.id = $("#deleteCommentModal").attr('data-comment-id');
  }

  return params;
} //}}}

function getEntry(params, error) //{{{
{
  var success = function (res) {
    var options = {
      getJaDate: function (date){
        var d = new Date(date.replace(/-/g, '/'));
        return d.getFullYear() + '年' + (d.getMonth() + 1) + '月' + d.getDate() + '日';
      },
      isStillApply: function (date) {
        var d = new Date(date.replace(/-/g, '/'));
        var today = new Date();
        today.setHours(0)
        today.setMinutes(0)
        today.setSeconds(0)
        today.setMilliseconds(0)
        return today.getTime() <= d.getTime();
      },
    }
    $('#show').html( $('#eventEntry').tmpl(res.data, options) );
    getComments();
    if (error) {
      $(error).show();
    }
  }

  $('#loading').show();

  ajax({
    url: 'event/search.json',
    data: params || getParams('event_search'),
    success: success,
  });
} //}}}

function getComments(params){ //{{{
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
  };

  ajax({
    url: 'event_comment/search.json',
    data: params || getParams( 'event_comment_search' ),
    success: success,
  });
} //}}}

function postEventComment(params) { //{{{
  toggleSubmitState();
  $('#comment-error').hide();

  var success = function (res) {
    $('#required').hide();
    var postedComment = $('#eventComment').tmpl(res.data,
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
    url: 'event_comment/post.json',
    data: params,
    type: 'POST',
    success: success,
    error: error,
    complete: toggleSubmitState,
  })
} //}}}

function postEventJoin(params) { //{{{
  toggleSubmitState();
  $('#comment-error').hide();

  var success = function (res) {
    toggleSubmitState();
    postEventComment( getParams('event_comment_post') );

    if (res.data[0].participants) {
      $('#participants').html(res.data[0].participants + '(<a href="' + res.data[0].id + '/memberList">参加者一覧</a>)')
    }
    else {
      $('#participants').html(res.data[0].participants);
    }

    if (!res.data[0].is_event_member) {
      $('#postCancel').attr({id: 'postJoin'}).html('このイベントに参加する');
    }
    else {
      $('#postJoin').attr({id: 'postCancel'}).html('参加を取り消す');
    }
  }

  var error = function (res) {
    $('#comment-error').show();
    console.log(res);
  }

  ajax({
    url: 'event/join.json',
    type: 'POST',
    data: params,
    success: success,
    error: error,
  })
} //}}}

function deleteEvent(params) { //{{{
  var success = function (res) {
    window.location = '/communityEvent/listCommunity/' + res.data.community_id;
  }

  ajax({
    url: 'event/delete.json',
    type: 'POST',
    data: params,
    success: success,
  });
} //}}}

function deleteComment(params) { //{{{
  ajax({
    url: 'event_comment/delete.json',
    data: params,
    type: 'POST',
    success: function (res) { $('#comment' + res.data.id).remove(); },
  })
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
  }
  );
} //}}}

function toggleSubmitState() { //{{{
  $('.comment-button').toggle();
  $('.comment-form-loader').toggle();
} //}}}

// vim:sw=2 ts=2 et si fdm=marker:
