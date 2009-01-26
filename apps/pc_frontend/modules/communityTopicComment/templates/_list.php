<?php if ($commentPager->getNbResults()) : ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo __('Comments') ?></h3>
</div>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($commentPager, '@communityTopic_show?page=%d&id='.$communityTopic->getId()); ?></p></div>

<?php foreach ($commentPager->getResults() as $comment): ?>
<dl>
<dt><?php echo nl2br(op_format_date($comment->getUpdatedAt(), 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<?php echo $comment->getMember()->getName() ?><?php if ($comment->isDeletable($sf_user->getMemberId())): ?> <?php echo link_to(__('Delete'), '@communityTopic_comment_delete_confirm?id='.$comment->getId()) ?><?php endif; ?>
</div>
<div class="body"><?php echo op_url_cmd(nl2br($comment->getBody())) ?></div>
</dl>
<?php endforeach; ?>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($commentPager, '@communityTopic_show?page=%d&id='.$communityTopic->getId()); ?></p></div>

</div>
</div>
<?php endif; ?>
