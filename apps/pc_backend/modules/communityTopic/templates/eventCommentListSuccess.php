<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Event Comment List')); ?>

<?php echo $form->renderFormTag(url_for('communityTopic/eventCommentList')) ?>
<table>
<?php echo $form ?>
<tr>
<td colspan="2"><input type="submit" value="<?php echo __('Search') ?>" /></td>
</table>
</form>

<?php if (!$pager->getNbResults()): ?>
<?php echo __('There are no event comments matches search condition.') ?>
<?php else: ?>
<?php ob_start() ?>
<p><?php op_include_pager_navigation($pager, 'communityTopic/eventCommentList?page=%d') ?></p>
<?php $pagerNavi = ob_get_flush() ?>
<?php foreach ($pager->getResults() as $eventComment): ?>
<?php include_partial('communityTopic/eventCommentInfo', array(
  'eventComment' => $eventComment,
  'moreInfo' => array(
    link_to(__('Delete'), 'communityTopic/eventCommentDelete?id='.$eventComment->getId())
  )
)); ?>
<?php endforeach; ?>
<?php echo $pagerNavi ?>
<?php endif; ?>
