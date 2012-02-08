<?php use_helper('opCommunityTopic'); ?>
<?php $acl = opCommunityTopicAclBuilder::buildResource($communityTopic, array($sf_user->getMember())) ?>
<?php op_mobile_page_title($community->getName(), $communityTopic->getName()) ?>

<?php echo op_within_page_link() ?>
<?php echo op_format_date($communityTopic->getCreatedAt(), 'MM/dd HH:mm') ?>
<?php if ($communityTopic->getMemberId() === $sf_user->getMemberId()): ?>
<?php endif; ?><br>
<?php echo op_community_topic_link_to_member($communityTopic->getMember()) ?>
<?php if ($communityTopic->isEditable($sf_user->getMemberId())): ?>
&nbsp;[<?php echo link_to(__('Edit'), '@communityTopic_edit?id='.$communityTopic->getId()) ?>]
<?php endif ?>
<br>
<?php echo op_auto_link_text_for_mobile(nl2br($communityTopic->getBody())) ?><br>

<?php if (count($communityTopic->getImages())): ?>
<?php foreach ($communityTopic->getImages() as $image): ?>
<?php echo link_to(__('Image %number%', array('%number%' => $image->getNumber())), sf_image_path($image->File, array('size' => '240x320', 'f' => 'jpg'))) ?><br>
<?php endforeach; ?>
<?php endif; ?>

<?php include_component('communityTopicComment', 'list', array('communityTopic' => $communityTopic)) ?>

<?php echo op_within_page_link('') ?>
<?php if ($acl->isAllowed($sf_user->getMemberId(), null, 'addComment')): ?>
<hr color="<?php echo $op_color['core_color_11'] ?>">
<?php
$options['url'] = url_for('communityTopic_comment_create', $communityTopic);
$options['button'] = __('Post');
$options['isMultipart'] = true;
op_include_form('formTopicComment', $form, $options);
?>

<?php if ('example.com' !== sfConfig::get('op_mail_domain')): ?>
[i:106]<?php echo op_mail_to('mail_community_topic_comment_create', array('id' => $communityTopic->id), __('Post from E-mail')) ?><br>
<?php echo __('You can attach photo files to e-mail.') ?><br>
<?php endif; ?>
<?php endif; ?>
<hr color="<?php echo $op_color['core_color_11'] ?>">

<?php echo link_to(__('Topic List'), '@communityTopic_list_community?id='.$community->getId()) ?><br>
<?php echo link_to(__('%Community% Top'), 'community/home?id='.$community->getId()) ?>
