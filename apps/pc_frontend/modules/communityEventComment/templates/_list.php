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
<?php if ($_member = $comment->getMember()) : ?> <?php echo link_to($_member->getName(), 'member/profile?id='.$_member->getId()) ?><?php endif; ?>
<?php if ($comment->isDeletable($sf_user->getMemberId())): ?>
 <?php echo link_to(__('Delete'), '@communityEvent_comment_delete_confirm?id='.$comment->getId()) ?>
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
