<?php use_helper('Date') ?>
<?php
$options = array(
  'title'    => __('Search Community Topics'),
  'url'      => url_for('communityTopic/search'),
  'button'   => __('Search'),
  'method'   => 'get'
);
if (!$communityId)
{
  unset($form['target']);
  unset($form['id']);
}

op_include_form('searchCommunityTopic', $form, $options);
?>

<?php if ($pager->getNbResults()): ?>

<?php
$list = array();
foreach ($pager->getResults() as $key => $topic)
{
  $list[$key] = array();
  $list[$key][__('Name', array(), 'community_topic_form')] = $topic->getName();
  $list[$key][__('%community% Name')] = $topic->getCommunity()->getName();
  $list[$key][__('Body', array(), 'community_topic_form')] = $topic->getBody();
  $list[$key][__('Date Updated', array(), 'form_community')] = format_datetime($topic->getUpdatedAt(), 'f');
}

$options = array(
  'title'          => __('Search Results'),
  'pager'          => $pager,
  'link_to_page'   => 'communityTopic/search?page=%d',
  'list'           => $list,
  'link_to_detail' => $link_to_detail,
);

op_include_parts('searchResultList', 'searchResultCommunityTopic', $options);
?>
<?php else: ?>
<?php
if ('topic' === $type)
{
  $message = __('Your search queries did not match any community topics.');
}
else if ('event' === $type)
{
  $message = __('Your search queries did not match any community events.');
}
op_include_box('searchCommunityTopicResult', $message, array('title' => __('Search Results')));
?>
<?php endif; ?>
