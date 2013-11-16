<!-- for smartphone -->
<?php
op_smt_use_javascript('/opCommunityTopicPlugin/js/bootstrap-modal.js', 'last');
?>
<script type="text/javascript">
function showModal(modal){
  var windowHeight = window.outerHeight > $(window).height() ? window.outerHeight : $(window).height();
  $('.modal-backdrop').css({'position': 'absolute','top': '0', 'height': windowHeight});

  var scrollY = window.scrollY;
  var viewHeight = window.innerHeight ? window.innerHeight : $(window).height();
  var modalTop = scrollY + ((viewHeight - modal.height()) / 2 );

  modal.css('top', modalTop);
}

$(document).on('click', '#deleteEntry', function(e){
  $('#deleteEntryModal').on('shown', function(e){
      showModal($(this));
      return this;
    })
    .modal('show');

  e.preventDefault();
  return false;
});

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

</script>

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

<?php if ('topic' == $target): ?>
<div class="modal hide" id="deleteEntryModal">
  <div class="modal-header">
    <h5><?php echo __('Delete the '.$target.' and comments');?></h5>
  </div>
  <div class="modal-body">
    <p class="center"><?php echo __('Do you really delete this '.$target.'?');?></p>
  </div>
  <div class="modal-footer">
    <button class="btn modal-button" id="cancel"><?php echo __('Cancel ');?></button>
    <button class="btn btn-primary modal-button" id="execute"><?php echo __('Delete');?></button>
  </div>
</div>
<?php endif; ?>
