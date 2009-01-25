<?php use_helper('Date'); ?>

<div class="dparts topicTitle"><div class="parts">
<div class="partsHeading">
<h3><?php echo '['.$community->getName().'] '.'トピック' ?></h3>
</div>

<dl>
<dt><?php echo format_datetime($communityTopic->getCreatedAt(), 'f') ?></dt>
<dd>
<div class="title"><?php echo $communityTopic->getName() ?></div>
<div class="name"><?php echo link_to($communityTopic->getMember()->getName(), 'member/profile?id='.$communityTopic->getMember()->getId()) ?></div>
<div class="body"><?php echo nl2br($communityTopic->getBody()) ?></div>
</dd>
</dl>

<div class="operation"><?php echo link_to('トピック編集', 'communityTopic/edit?id='.$communityTopic->getId()) ?></div>

</div>
</div>

<?php include_component('communityTopicComment', 'list', array('communityTopic' => $communityTopic)) ?>

<?php
$options = array();
$options['title'] = 'コメント書き込み';
$options['url'] = '@communityTopic_comment_create?id='.$communityTopic->getId();
op_include_form('formCommunityTopicComment', $form, $options);
?>

<ul>
<li class="align-center"><?php echo link_to('['.$community->getName().']'.'コミュニティトップへ', 'community/home?id='.$community->getId());?></li>
</ul>
