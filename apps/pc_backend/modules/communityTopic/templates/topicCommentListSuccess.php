<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Topic Comment List')); ?>

<?php echo $form->renderFormTag(url_for('communityTopic/topicCommentList'), array('method' => 'get')) ?>
<table>
<?php echo $form ?>
<tr>
<td colspan="2"><input type="submit" value="<?php echo __('Search') ?>" /></td>
</tr>
</table>
</form>

<?php if (!$pager->getNbResults()): ?>
<?php echo __('There are no topic comments matches search condition.') ?>
<?php else: ?>
<?php ob_start() ?>
<p><?php op_include_pager_navigation($pager, 'communityTopic/topicCommentList?page=%d', array('use_current_query_string' => true)) ?></p>
<?php $pagerNavi = ob_get_flush() ?>
<?php foreach ($pager->getResults() as $topicComment): ?>
<?php include_partial('communityTopic/topicCommentInfo', array(
  'topicComment' => $topicComment,
  'moreInfo' => array(
    link_to(__('Delete'), 'communityTopic/topicCommentDelete?id='.$topicComment->getId())
  )
)); ?>
<?php endforeach; ?>
<?php echo $pagerNavi ?>
<?php endif; ?>
