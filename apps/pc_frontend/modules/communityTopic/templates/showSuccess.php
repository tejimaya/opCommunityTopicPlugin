<?php use_helper('Date', 'opCommunityTopic'); ?>
<?php $acl = opCommunityTopicAclBuilder::buildCollection($community, array($sf_user->getMember())) ?>

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
<p><?php if ($_member = $communityTopic->getMember()) : ?><?php echo op_community_topic_link_to_member($_member) ?><?php endif; ?></p>
</div>
<div class="body">
<?php if (count($images = $communityTopic->getImages()) != 0): ?>
<ul class="photo">
<?php foreach ($images as $image): ?>
<li><a href="<?php echo sf_image_path($image->File) ?>" target="_blank"><?php echo image_tag_sf_image($image->File, array('size' => '120x120')) ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
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
$options['url'] = url_for('communityTopic_comment_create', $communityTopic);
$options['isMultipart'] = true;
op_include_form('formCommunityTopicComment', $form, $options);
?>
<?php endif; ?>

<?php op_include_line('linkLine', link_to('['.$community->getName().'] '.__('%Community% Top Page'), 'community/home?id='.$community->getId())) ?>
