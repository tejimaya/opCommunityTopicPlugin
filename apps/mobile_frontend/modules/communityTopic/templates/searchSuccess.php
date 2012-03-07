<?php op_mobile_page_title(__('Search %Community% Topics')) ?>

<?php if ($isResult): ?>
<?php if ($pager->getNbResults()): ?>

<center>
<?php echo pager_total($pager) ?>
</center>

<?php
$options = array(
  'pager'          => $pager,
  'type'           => $type,
  'link_to_detail' => $link_to_detail,
);

include_partial('partsSearchResultList', $options);
?>

<?php
if ($pager->haveToPaginate())
{
  op_include_pager_navigation($pager, url_for($pageUrl).'?page=%d', array('is_total' => false, 'use_current_query_string' => true));
}
?>
<hr color="<?php echo $op_color['core_color_11'] ?>">
<?php else: ?>
<?php
if ('topic' === $type)
{
  $message = __('Your search queries did not match any %community% topics.');
}
else if ('event' === $type)
{
  $message = __('Your search queries did not match any %community% events.');
}
op_include_box('searchCommunityTopicResult', $message);
?>
<?php endif; ?>
<?php endif; ?>

<?php
$options = array(
  'title'    => __('Search %Community% Topics'),
  'button'   => __('Search'),
  'method'   => 'get'
);
op_include_form('searchCommunityTopic', $form, $options);
?>

<hr color="<?php echo $op_color['core_color_11'] ?>">
<?php
if ($communityId)
{
  echo link_to(__('%Community% Top'), 'community/home?id='.$communityId);
}
else
{
  echo link_to(__('Search %Community%', array('%Community%' => $op_term['community']->pluralize())), 'community/search');
}
