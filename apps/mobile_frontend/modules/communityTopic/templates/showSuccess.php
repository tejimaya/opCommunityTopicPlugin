<?php $acl = opCommunityTopicAclBuilder::buildResource($communityTopic, array($sf_user->getMember())) ?>
<?php op_mobile_page_title($community->getName(), $communityTopic->getName()) ?>

<?php echo op_within_page_link() ?>
<?php echo op_format_date($communityTopic->getTopicUpdatedAt(), 'XDateTime') ?>
<?php if ($communityTopic->getMemberId() === $sf_user->getMemberId()): ?>
<?php endif; ?><br>
<?php echo link_to($communityTopic->getMember()->getName(), 'member/profile?id='.$communityTopic->getMember()->getId()) ?>
<?php if ($communityTopic->isEditable($sf_user->getMemberId())): ?>
&nbsp;[<?php echo link_to(__('Edit'), '@communityTopic_edit?id='.$communityTopic->getId()) ?>]
<?php endif ?>
<br>
<?php echo nl2br($communityTopic->getBody()) ?><br>

<?php include_component('communityTopicComment', 'list', array('communityTopic' => $communityTopic)) ?>

<?php echo op_within_page_link('') ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'addComment')): ?>
<hr>
<?php
$options['title'] = __('Post a new topic comment');
$options['url'] = url_for('communityTopic_comment_create', $communityTopic);
$options['button'] = __('Save');
$options['isMultipart'] = true;
op_include_form('formTopicComment', $form, $options);
?>
<?php endif; ?>
<hr>

<?php echo link_to(__('Topic List'), '@communityTopic_list_community'.$community->getId()) ?><br>
<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
