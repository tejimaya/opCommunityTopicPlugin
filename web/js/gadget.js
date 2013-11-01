var gadget = {
  search: function(params, target){
    $.getJSON(openpne.apiBase + target + '/search.json',
      params,
      function(res)
      {
        if (res.data.length > 0)
        {
          var entry = $('#' + target + 'Entry').tmpl(res.data,
          {
            calcTimeAgo: function(){
              return moment(this.data.created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
            }
          });
          $('#' + target + 'List').append(entry);
          $('#' + target + 'readmore').show();
        }
        else
        {
          $('#' + target + 'List').append('<p>表示する情報がありません。</p>');
        }
      }
    );
  }
}
