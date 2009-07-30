<?php if ($commentPager->getNbResults()): ?>
<hr color="<?php echo $op_color['core_color_11'] ?>">
<center>
<?php echo __('Comments', array(), 'form_community') ?><br>
<?php op_include_pager_total($commentPager) ?>
</center>

<?php
foreach ($commentPager->getResults() as $comment)
{
  $list[] = get_partial('communityTopicComment/comment', array('comment' => $comment));
}

op_include_list('commentList', $list, array('border' => true));
?>
<?php if ($commentPager->haveToPaginate()): ?>
<?php op_include_pager_navigation($commentPager, '@communityTopic_show?id='.$communityTopic->getId().'&page=%d') ?>
<?php endif; ?>
<?php endif; ?>
