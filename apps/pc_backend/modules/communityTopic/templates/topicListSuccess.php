<?php slot('submenu') ?>
<?php include_partial('submenu') ?>
<?php end_slot() ?>

<?php slot('title', __('Topic List')); ?>

<?php echo $form->renderFormTag(url_for('communityTopic/topicList'), array('method' => 'get')) ?>
<table>
<?php echo $form ?>
<tr>
<td colspan="2"><input type="submit" value="<?php echo __('Search') ?>" /></td>
</tr>
</table>
</form>

<?php if (!$pager->getNbResults()): ?>
<?php echo __('There are no topics matches search condition.') ?>
<?php else: ?>
<?php ob_start() ?>
<p><?php op_include_pager_navigation($pager, 'communityTopic/topicList?page=%d', array('use_current_query_string' => true)) ?></p>
<?php $pagerNavi = ob_get_flush() ?>
<?php foreach ($pager->getResults() as $topic): ?>
<?php include_partial('communityTopic/topicInfo', array(
  'topic' => $topic,
  'moreInfo' => array(
    link_to(__('Delete'), 'communityTopic/topicDelete?id='.$topic->getId())
  )
)); ?>
<?php endforeach; ?>
<?php echo $pagerNavi ?>
<?php endif; ?>
