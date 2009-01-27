<?php use_helper('Date'); ?>

<div class="dparts topicDetailBox"><div class="parts">
<div class="partsHeading">
<h3><?php echo '['.$community->getName().'] '.__('Topic') ?></h3>
</div>
<dl>
<dt><?php echo nl2br(op_format_date($communityTopic->getCreatedAt(), 'XDateTimeJaBr')) ?></dt>
<dd>
<div class="title">
<p><?php echo $communityTopic->getName() ?></p>
</div>
<div class="name">
<p><?php echo link_to($communityTopic->getMember()->getName(), 'member/profile?id='.$communityTopic->getMember()->getId()) ?></p>
</div>
<div class="body">
<p class="text">
<?php echo op_url_cmd(nl2br($communityTopic->getBody())) ?>
</p>
</div>
</dd>
</dl>
<?php if ($communityTopic->isEditable($sf_user->getMemberId())): ?>
<div class="operation">
<form action="<?php echo url_for('communityTopic_edit', $communityTopic) ?>" method="get">
<ul class="moreInfo button">
<li><input class="input_submit" type="submit" value="<?php echo __('Edit') ?>" /></li>
</ul>
</form>
</div>
<?php endif; ?>
</div>
</div>

<?php include_component('communityTopicComment', 'list', array('communityTopic' => $communityTopic)) ?>

<?php if ($communityTopic->isCreatableCommunityTopicComment($sf_user->getMemberId())): ?>
<?php
$options = array();
$options['title'] = __('Post a new topic comment');
$options['url'] = '@communityTopic_comment_create?id='.$communityTopic->getId();
op_include_form('formCommunityTopicComment', $form, $options);
?>
<?php endif; ?>

<?php op_include_line('linkLine', link_to('['.$community->getName().'] '.__('Community Top Page'), 'community/home?id='.$community->getId())) ?>
