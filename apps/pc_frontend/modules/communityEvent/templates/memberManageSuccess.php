<?php use_helper('opCommunityTopic'); ?>
<?php slot('pager') ?>
<?php op_include_pager_navigation($pager, '@communityEvent_memberManage?page=%d&id='.$sf_params->get('id')); ?>
<?php end_slot(); ?>

<div class="parts">
<div class="partsHeading"><h3><?php echo __('Management member') ?></h3></div>
<?php include_slot('pager') ?>
<div class="item">
<table>
<tbody>
<?php foreach ($pager->getResults() as $member) : ?>
<tr>
<td class="member"><?php echo op_community_topic_link_to_member($member); ?></td>
<td>
<?php echo link_to(__('Delete'), url_for('@communityEvent_memberDeleteConfirm?community_event_id='.$communityEvent->getId().'&member_id='.$member->getId())) ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php include_slot('pager') ?>
</div>

<?php op_include_form('formCommunityEventMemberAdd', $form, array(
  'title' => __('Add Event Member'),
  'url' => url_for('@communityEvent_memberAdd?id='.$communityEvent->getId()),
)) ?>
