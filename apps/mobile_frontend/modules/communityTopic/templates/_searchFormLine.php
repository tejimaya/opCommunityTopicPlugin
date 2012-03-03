<?php
$id = sfContext::getInstance()->getRequest()->getParameter('id');
$options = array(
  'title'    => __('Search %Community% Topics'),
  'url'      => url_for('communityTopic_search', $community),
  'button'   => __('Search'),
  'method'   => 'get'
);

$form = new PluginCommunityTopicSearchForm();
op_include_form('searchCommunityTopic', $form, $options);
?>
