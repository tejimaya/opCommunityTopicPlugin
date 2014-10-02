<script type="text/javascript">
$(document).ready(function() {
  $('.reply').click(function() {
    var element = $('#community_event_comment_body'); 
    element.val(element.val() + '>>' + $(this).attr('number') + ' ' + $(this).attr('name') + "\n");
    element.focus();
  })
})
</script>
    
<?php use_helper('opCommunityTopic'); ?>
<?php if ($commentPager->getNbResults()) : ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Comments', array(), 'form_community') ?></h3>
</div>

<?php ob_start() ?>
<?php op_include_pager_navigation($commentPager, '@communityEvent_show?page=%d&id='.$communityEvent->getId()); ?>
<?php $pagerNavi = ob_get_contents() ?>
<?php ob_end_flush() ?>

<?php foreach ($commentPager->getResults() as $comment): ?>
<dl>
<dt><?php echo nl2br(op_format_date($comment->getCreatedAt(), 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<p class="heading"><strong><?php echo $comment->getNumber() ?></strong>:
<?php if ($_member = $comment->getMember()) : ?> <?php echo op_community_topic_link_to_member($_member) ?><?php endif; ?>
<?php if ($comment->isDeletable($sf_user->getMemberId())): ?>
 <?php echo link_to(__('Delete'), '@communityEvent_comment_delete_confirm?id='.$comment->getId()) ?>
<?php endif; ?>
<?php if('1'== Doctrine::getTable('SnsConfig')->get('op_community_topic_plugin_community_event_comment_reply')): ?>
  <a class="reply" href="javascript:void(0);" name="<?php echo $comment->Member->name; ?>" number="<?php echo $comment->number; ?>"><?php echo __('Reply') ?></a>
<?php endif; ?>
</p>
</div>
<div class="body">
<?php
// sfReversibleDoctrinePager taints record state. It should be clean for working browsing relations
$comment->state(Doctrine_Record::STATE_CLEAN);
$images = $comment->getImages();
?>
<?php if (count($images)): ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->File) ?>" target="_blank"><?php echo image_tag_sf_image($image->File, array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<p class="text">
<?php echo op_url_cmd(nl2br($comment->getBody())) ?>
</p>
</div>
</dd>
</dl>
<?php endforeach; ?>

<?php echo $pagerNavi ?>

</div>
</div>
<?php endif; ?>
