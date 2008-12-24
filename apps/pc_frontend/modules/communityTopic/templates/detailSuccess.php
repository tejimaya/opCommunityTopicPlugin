<?php use_helper('Pagination', 'Date'); ?>

<div class="dparts topicTitle"><div class="parts">
<div class="partsHeading">
<h3><?php echo '['.$community->getName().'] '.'トピック' ?></h3>
</div>

<table><tbody>
<tr>
<th rowspan=2><?php echo format_datetime($communityTopic->getUpdatedAt(), 'f'); ?></th>
<td><?php echo $communityTopic->getName(); ?></td>
</tr>
<tr>
<td class="border-left"><?php echo $communityTopic->getMember()->getName(); ?></td>
</tr>
<tr>
<td class="align-center" colspan=2><?php echo link_to('トピック編集', 'communityTopic/edit?id='.$communityTopic->getId()); ?></td>
</tr>
</tbody>
</table>

</div>
</div>

<?php if ($communityTopic->countCommunityTopicComments()) : ?>
<div class="dparts commentList"><div class="parts">
<div class="partsHeading">
<h3><?php echo '書き込み' ?></h3>
</div>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($commentPager, 'communityTopic/detail?page=%d&id='.$communityTopic->getId()); ?></p></div>

<table><tbody>
<?php foreach ($commentPager->getResults() as $comment): ?>
<tr>
<th rowspan=2><?php echo format_datetime($comment->getUpdatedAt(), 'f'); ?></th>
<td><?php echo $comment->getMember()->getName().' '.link_to('削除', 'comment/delete?id='.$communityTopic->getId().'&comment_id='.$comment->getId()) ?></td>
</tr>
<tr>
<td class="border-left"><?php echo $comment->getBody() ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<div class="pagerRelative"><p class="number"><?php echo pager_navigation($commentPager, 'communityTopic/detail?page=%d&id='.$communityTopic->getId()); ?></p></div>

</div>
</div>
<?php endif; ?>

<?php
$options = array(
  'form' => array($form),
  'button' => __('書き込み'),
);
$title = 'コメント書き込み';
$options['url'] = 'communityTopic/detail?id='.$communityTopic->getId();
include_box('formCommunityTopicComment', $title, '', $options);
?>

<ul>
<li class="align-center"><?php echo link_to('['.$community->getName().']'.'コミュニティトップへ', 'community/home?id='.$community->getId());?></li>
</ul>
