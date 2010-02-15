<?php
function isViewable()
{
  $context = sfContext::getInstance();
  $communityId = $context->getRequest()->getParameter('id');
  !$context->getUser()->getMemberId() && 'open' !== Doctrine::getTable('CommunityConfig')->retrieveByNameAndCommunityId('public_flag', $communityId);
}

$actions = array('home', 'search', 'joinList', 'memberList');

foreach ($actions as $action)
{
  $dispatcher = new sfEventDispather();
  $dispatcher->connect('op_action.pre_execute_community'.$action, 'isViewable');
}
