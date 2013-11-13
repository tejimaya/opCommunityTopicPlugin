function showModal(modal){
  var windowHeight = window.outerHeight > $(window).height() ? window.outerHeight : $(window).height();
  $('.modal-backdrop').css({'position': 'absolute','top': '0', 'height': windowHeight});

  var scrollY = window.scrollY;
  var viewHeight = window.innerHeight ? window.innerHeight : $(window).height();
  var modalTop = scrollY + ((viewHeight - modal.height()) / 2 );

  modal.css('top', modalTop);
}

function _timeAgo(created_at){
  return moment(created_at, 'YYYY-MM-DD HH:mm:ss').fromNow();
}

