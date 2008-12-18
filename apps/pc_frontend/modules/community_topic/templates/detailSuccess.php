<ul>
<li><?php echo 'community_topic_name = '.$communityTopic->getName(); ?></li>
<li><?php echo 'id = '.$communityTopic->getId(); ?></li>

<?php foreach ($comments as $comment): ?>
<li>
<?php
echo 'コメント '.$comment->getBody().' 書き込んだ人'.$comment->getMemberId();
echo link_to('編集', 'community_topic/detail?id='.$communityTopic->getId().'&comment_id='.$comment->getId());
echo ' ';
echo link_to('削除', 'comment/delete?id='.$communityTopic->getId().'&comment_id='.$comment->getId());
?></li>
<?php endforeach; ?>

</ul>

<?php
$options = array('form' => array($form));
if ($form->isNew()) {
  $title = 'コメント書き込み';
  $options['url'] = 'community_topic/detail?id='.$communityTopic->getId();
} else {
  $title = 'コメント編集';
  $options['url'] = 'community_topic/detail?id='.$communityTopic->getId().'&comment_id='.$comment->getId();
}
include_box('formCommunityTopicComment', $title, '', $options);
?>
