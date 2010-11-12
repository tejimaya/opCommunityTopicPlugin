<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$_app = 'pc_backend';
$browser = new opTestFunctional(new opBrowser(), new lime_test(null, new lime_output_color()));
$browser
  ->info('Login')
  ->get('/default/login')
  ->click('ログイン', array('admin_user' => array(
    'username' => 'admin',
    'password' => 'password',
  )))
  ->isStatusCode(302)

// CSRF
  ->info('/communityTopic/topicDelete/id/1 - CSRF')
  ->post('/communityTopic/topicDelete/id/1')
  ->checkCSRF()

  ->info('/communityTopic/topicCommentDelete/id/1 - CSRF')
  ->post('/communityTopic/topicCommentDelete/id/1')
  ->checkCSRF()

  ->info('/communityTopic/eventDelete/id/1 - CSRF')
  ->post('/communityTopic/eventDelete/id/1')
  ->checkCSRF()

  ->info('/communityTopic/eventCommentDelete/id/1 - CSRF')
  ->post('/communityTopic/eventCommentDelete/id/1')
  ->checkCSRF()

  ->info('/communityTopic/eventMemberDelete/id/1 - CSRF')
  ->post('/communityTopic/eventMemberDelete/id/1')
  ->checkCSRF()

  ->info('/opCommunityTopicPlugin/index - CSRF')
  ->post('/opCommunityTopicPlugin/index')
  ->checkCSRF()

// XSS
  ->info('/communityTopic/index - XSS')
  ->get('/communityTopic/index')
  ->click('検索', array('communityTopic' => array('name' => array('text' => 'CommunityTopic.name'))))
  ->with('html_escape')->begin()
    ->isAllEscapedData('CommunityTopic', 'name')
    ->isAllEscapedData('CommunityTopic', 'body')
  ->end()

  ->info('/communityTopic/topicCommentList - XSS')
  ->get('/communityTopic/topicCommentList')
  ->click('検索', array('communityTopicComment' => array('member_name' => 'Member.name')))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('CommunityTopicComment', 'body')
  ->end()

  ->info('/communityTopic/eventList - XSS')
  ->get('/communityTopic/eventList')
  ->click('検索', array('communityEvent' => array('name' => array('text' => 'CommunityEvent.name'))))
  ->with('html_escape')->begin()
    ->isAllEscapedData('CommunityEvent', 'name')
    ->isAllEscapedData('CommunityEvent', 'body')
  ->end()

  ->info('/communityTopic/eventCommentList - XSS')
  ->get('/communityTopic/eventCommentList')
  ->click('検索', array('communityEventComment' => array('member_name' => 'Member.name')))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('CommunityEventComment', 'body')
  ->end()

  ->info('/communityTopic/eventMemberList - XSS')
  ->get('/communityTopic/eventMemberList')
  ->click('検索', array('communityEventMember' => array('member_name' => array('text' => 'Member.name'))))
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('CommunityEvent', 'name')
  ->end()

  ->info('/communityTopic/topicDelete/id/1055 - XSS')
  ->get('/communityTopic/topicDelete/id/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('CommunityTopic', 'name')
    ->isAllEscapedData('CommunityTopic', 'body')
  ->end()

  ->info('/communityTopic/topicCommentDelete/id/1055 - XSS')
  ->get('/communityTopic/topicCommentDelete/id/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('CommunityTopicComment', 'body')
  ->end()

  ->info('/communityTopic/eventDelete/id/1055 - XSS')
  ->get('/communityTopic/eventDelete/id/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('CommunityEvent', 'name')
    ->isAllEscapedData('CommunityEvent', 'body')
  ->end()

  ->info('/communityTopic/eventCommentDelete/id/1055 - XSS')
  ->get('/communityTopic/eventCommentDelete/id/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('CommunityEventComment', 'body')
  ->end()

  ->info('/communityTopic/eventMemberDelete/id/1055 - XSS')
  ->get('/communityTopic/eventMemberDelete/id/1055')
  ->with('html_escape')->begin()
    ->isAllEscapedData('Member', 'name')
    ->isAllEscapedData('CommunityEvent', 'name')
  ->end()
;
