<?php if ($commentPager->getNbResults()): ?>
<hr>
<center>
<?php echo __('Comments', array(), 'form_community') ?><br>
<?php op_include_pager_total($commentPager) ?>
</center>

<?php foreach ($commentPager->getResults() as $comment): ?>
<hr>
<?php echo op_within_page_link() ?>
[<?php printf('%03d', $comment->getNumber()) ?>]<?php echo op_format_date($comment->getCreatedAt(), 'MM/dd HH:mm') ?><br>
<?php echo link_to($comment->getMember()->getName(), 'member/profile?id='.$comment->getMemberId()) ?>
<?php if ($comment->isDeletable($sf_user->getMemberId())): ?>
&nbsp;[<?php echo link_to(__('Delete'), '@communityEvent_comment_delete_confirm?id='.$comment->getId()) ?>]
<?php endif; ?><br>
<?php echo nl2br($comment->getBody()) ?>
<?php endforeach; ?>
<?php if ($commentPager->haveToPaginate()): ?>
<hr>
<?php op_include_pager_navigation($commentPager, '@communityEvent_show?id='.$communityEvent->getId().'&page=%d') ?>
<?php endif; ?>
<?php endif; ?>
