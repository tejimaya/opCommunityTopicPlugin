<?php if ($commentPager->getNbResults()) : ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo '書き込み' ?></h3>
</div>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($commentPager, '@communityTopic_show?page=%d&id='.$communityTopic->getId()); ?></p></div>

<table><tbody>
<?php foreach ($commentPager->getResults() as $comment): ?>
<tr>
<th rowspan=2><?php echo format_datetime($comment->getUpdatedAt(), 'f'); ?></th>
<td><?php echo $comment->getMember()->getName() ?><?php if ($comment->isDeletable($sf_user->getMemberId())): ?> <?php echo link_to(__('Delete'), '@communityTopic_comment_delete_confirm?id='.$comment->getId()) ?><?php endif; ?></td>
</tr>
<tr>
<td class="border-left"><?php echo $comment->getBody() ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($commentPager, '@communityTopic_show?page=%d&id='.$communityTopic->getId()); ?></p></div>

</div>
</div>
<?php endif; ?>

