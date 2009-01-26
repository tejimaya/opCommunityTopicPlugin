<?php use_helper('Date'); ?>

<?php if ($community->isCreatableCommunityTopic($sf_user->getMemberId())): ?>
<?php
$title = 'トピックを作成する';
$body = link_to('新規作成', 'communityTopic_new', $community);
include_box('communityTopicList', $title, $body);
?>
<?php endif; ?>

<div class="dparts topicList"><div class="parts">
<div class="partsHeading">
<h3><?php echo 'トピック一覧'; ?></h3>
</div>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, '@communityTopic_list_community?page=%d&id='.$community->getId()) ?></p></div>

<table><tbody>
<?php foreach ($pager->getResults() as $topic): ?>
<tr>
<th rowspan=2><?php echo format_datetime($topic->getUpdatedAt(), 'f') ?></th>
<td><?php echo link_to($topic->getName(), 'communityTopic_show', $topic) ?></td>
</tr>
<tr>
<td class="border-left align-right">
<?php if ($topic->isEditable($sf_user->getMemberId())): ?>
<?php echo link_to('編集', 'communityTopic/edit?id='.$topic->getId()); ?>
<?php endif; ?>
 <?php echo link_to('もっと見る'.'('.$topic->countCommunityTopicComments().')', 'communityTopic_show', $topic); ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($pager, '@communityTopic_list_community?page=%d&id='.$community->getId()) ?></p></div>

</div>
</div>
