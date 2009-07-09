<?php if ($commentPager->getNbResults()) : ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Comments', array(), 'form_community') ?></h3>
</div>

<?php ob_start() ?>
<?php op_include_pager_navigation($commentPager, '@communityTopic_show?page=%d&id='.$communityTopic->getId()); ?>
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
 <?php echo link_to(__('Delete'), '@communityTopic_comment_delete_confirm?id='.$comment->getId()) ?>
<?php endif; ?>
</p>
</div>
<div class="body">
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
