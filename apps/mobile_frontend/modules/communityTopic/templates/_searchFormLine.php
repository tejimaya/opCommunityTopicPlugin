<?php
$form = new PluginCommunityTopicSearchForm();
$form->bind(array('id' => sfContext::getInstance()->getRequest()->getParameter('id')));

$options = array(
  'title'    => __('Search Community Topics'),
  'url'      => url_for('communityTopic/search'),
  'button'   => __('Search'),
  'method'   => 'get'
);

op_include_form('searchCommunityTopic', $form, $options);
?>
