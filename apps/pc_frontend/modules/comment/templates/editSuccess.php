<ul>
<li><?php echo 'topic_name = '.$topic_name; ?></li>
<li><?php echo 'id = '.$id; ?></li>
<?php foreach ($comments as $comment): ?>
<li><?php echo 'コメント '.$comment->getBody().' 書き込んだ人'.$comment->getMemberId(); ?></li>
<?php endforeach; ?>
</ul>





<li><?php echo link_to('トピック追加', 'community_topic/edit?community_id='.$community->getId()) ?></li>
