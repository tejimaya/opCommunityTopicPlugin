<?php op_mobile_page_title($community->getName(), $communityEvent->getName()) ?>

<?php echo op_within_page_link() ?>
<?php
$list = array(
  'Writer'               => link_to($communityEvent->getMember()->getName(), 'member/profile?id='.$communityEvent->getMember()->getId()),
  'Open date'            => op_format_date($communityEvent->getOpenDate(), 'D').($communityEvent->getOpenDate() ? ' '.$communityEvent->getOpenDateComment() : ''),
  'Area'                 => $communityEvent->getArea(),
  'Capacity'             => $communityEvent->getCapacity() ? $communityEvent->getCapacity() : __('Limitless'),
  'Count of Member'      => __('%1% persons', array('%1%' => $communityEvent->countCommunityEventMembers())),
);

if (!$communityEvent->getMember() || !$communityEvent->getMember()->getName())
{
  $list['Writer'] = '';
}

if ($communityEvent->countCommunityEventMembers())
{
  $list['Count of Member'] .= '<br>'.link_to(__('See Member List'), '@communityEvent_memberList?id='.$communityEvent->getId());
}

if ($communityEvent->getApplicationDeadline())
{
  $list['Application deadline'] = op_format_date($communityEvent->getApplicationDeadline(), 'D');
}

$image_html = '';
if (count($communityEvent->getImages()))
{
  $image_html .= '<br>';
  foreach ($communityEvent->getImages() as $image)
  {
    $image_html .= '<br>'.link_to(__('Image %number%', array('%number%' => $image->getNumber())), sf_image_path($image->File, array('size' => '240x320', 'f' => 'jpg')));
  }
}

$list['Body'] = nl2br($communityEvent->getBody()).$image_html.'<br>'.op_format_date($communityEvent->getCreatedAt(), 'MM/dd HH:mm');

if ($communityEvent->isEditable($sf_user->getMemberId()))
{
  $list[__('Edit this event')] = link_to(__('See event edit form'), '@communityEvent_edit?id='.$communityEvent->getId());
}

foreach ($list as $key => $value)
{
  echo '<br>'.__($key, array(), 'community_event_form').':<br>'.$value.'<br>';
}
?>

<?php include_component('communityEventComment', 'list', array('communityEvent' => $communityEvent)) ?>

<?php echo op_within_page_link('') ?>
<?php if ($communityEvent->isCreatableCommunityEventComment($sf_user->getMemberId())): ?>
<hr color="<?php echo $op_color['core_color_11'] ?>">
<div id="formEventComment">
<table>
<form action="<?php echo url_for('communityEvent_comment_create', $communityEvent) ?>" method="post">
<?php echo $form ?>
<?php if (!$communityEvent->isClosed() && !$communityEvent->isExpired()): ?>
<?php if ($communityEvent->isEventMember($sf_user->getMemberId())): ?>
<input name="cancel" class="input_submit" type="submit" value="<?php echo __('Cancel') ?>" />
<?php elseif (!$communityEvent->isAtCapacity()): ?>
<input name="participate" class="input_submit" type="submit" value="<?php echo __('Participate in this event') ?>" />
<?php endif; ?>
<br>
<?php endif; ?>
<input name="comment" class="input_submit" type="submit" value="<?php echo __('Add a comment only') ?>" />
</form>
</table>
</div>
<?php if ('example.com' !== sfConfig::get('op_mail_domain')): ?>
[i:106]<?php echo op_mail_to('mail_community_event_comment_create', array('id' => $communityEvent->id), __('Post from E-mail')) ?><br>
<?php echo __('You can attach photo files to e-mail.') ?><br>
<?php endif; ?>
<?php endif; ?>
<hr color="<?php echo $op_color['core_color_11'] ?>">

<?php echo link_to(__('List of events'), '@communityEvent_list_community?id='.$community->getId()) ?><br>
<?php echo link_to(__('Community Top'), 'community/home?id='.$community->getId()) ?>
