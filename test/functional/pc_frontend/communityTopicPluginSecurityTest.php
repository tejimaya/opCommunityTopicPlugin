<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');
include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new opTestFunctional(new opBrowser(), new lime_test(50, new lime_output_color()));

$browser

->login('html1@example.com', 'password')

// CSRF
->info('/communityEvent/create - CSRF')
->post('/communityEvent/create/1055')
->checkCSRF()

->info('/communityEvent/delete - CSRF')
->post('/communityEvent/delete/1055')
->checkCSRF()

->info('/communityEvent/update - CSRF')
->post('/communityEvent/update/1055')
->checkCSRF()

->info('/communityEventComment/create - CSRF')
->post('/communityEvent/1055/comment/create')
->checkCSRF()

->info('/communityEventComment/delete - CSRF')
->post('/communityEvent/comment/delete/1055')
->checkCSRF()

->info('/communityTopic/create - CSRF')
->post('/communityTopic/create/1055')
->checkCSRF()

->info('/communityTopic/delete - CSRF')
->post('/communityTopic/delete/1055')
->checkCSRF()

->info('/communityTopic/update - CSRF')
->post('/communityTopic/update/1055')
->checkCSRF()

->info('/communityTopicComment/create - CSRF')
->post('/communityTopic/1055/comment/create')
->checkCSRF()

->info('/communityTopicComment/delete - CSRF')
->post('/communityTopic/comment/delete/1055')
->checkCSRF()

->info('/communityTopic/configNotificationMail - CSRF')
->post('/config/communityTopicNotificationMail/1055', array(
  'topic_notify' => array(),
))
->followRedirect()
->checkCSRF()

// XSS
->info('/communityEvent/edit - XSS')
->get('/communityEvent/edit/1055')
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityEvent', 'name')
  ->isAllEscapedData('CommunityEvent', 'body')
  ->isAllEscapedData('CommunityEvent', 'open_date_comment')
  ->isAllEscapedData('CommunityEvent', 'area')
->end()

->info('/communityEvent/listCommunity - XSS')
->get('/communityEvent/listCommunity/1055')
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityEvent', 'name')
->end()

->info('/communityEvent/memberList - XSS')
->get('/communityEvent/1055/memberList')
->with('html_escape')->begin()
  ->isAllEscapedData('Member', 'name')
->end()

->info('/communityEvent/recentlyEventList - XSS')
->get('/communityEvent/recentlyEventList')
->with('html_escape')->begin()
  ->isAllEscapedData('Community', 'name')
  ->isAllEscapedData('CommunityEvent', 'name')
->end()

->info('/communityEvent/show - XSS')
->get('/communityEvent/1055')
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityEvent', 'name')
  ->isAllEscapedData('CommunityEvent', 'body')
  ->isAllEscapedData('CommunityEvent', 'open_date_comment')
  ->isAllEscapedData('CommunityEvent', 'area')
  ->isAllEscapedData('CommunityEventComment', 'body')
  ->isAllEscapedData('Member', 'name')
->end()

->info('/communityTopic/edit - XSS')
->get('/communityTopic/edit/1055')
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityTopic', 'name')
  ->isAllEscapedData('CommunityTopic', 'body')
->end()

->info('/communityTopic/listCommunity - XSS')
->get('/communityTopic/listCommunity/1055')
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityTopic', 'name')
->end()

->info('/communityTopic/recentlyTopicList - XSS')
->get('/communityTopic/recentlyTopicList')
->with('html_escape')->begin()
  ->isAllEscapedData('Community', 'name')
  ->isAllEscapedData('CommunityTopic', 'name')
->end()

->info('/communityTopic/show - XSS')
->get('/communityTopic/1055')
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityTopic', 'name')
  ->isAllEscapedData('CommunityTopic', 'body')
  ->isAllEscapedData('Member', 'name')
->end()

->info('/communityTopic/search - XSS')
->get('/communityTopic/search', array(
  'type'    => 'topic',
  'keyword' => opTesterHtmlEscape::getRawTestData('CommunityTopic', 'name'),
))
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityTopic', 'name')
  ->countEscapedData(1, 'Community', 'name', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
  ->countEscapedData(1, 'CommunityTopic', 'body', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
->end()

->get('/communityTopic/search', array(
  'type'    => 'event',
  'keyword' => opTesterHtmlEscape::getRawTestData('CommunityEvent', 'name'),
))
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityEvent', 'name')
  ->countEscapedData(1, 'Community', 'name', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
  ->countEscapedData(1, 'CommunityEvent', 'body', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
->end()

->get('/communityTopic/search/1055', array(
  'type'    => 'topic',
  'keyword' => opTesterHtmlEscape::getRawTestData('CommunityTopic', 'name'),
))
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityTopic', 'name')
  ->countEscapedData(1, 'Community', 'name', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
  ->countEscapedData(1, 'CommunityTopic', 'body', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
->end()

->get('/communityTopic/search/1055', array(
  'type'    => 'event',
  'keyword' => opTesterHtmlEscape::getRawTestData('CommunityEvent', 'name'),
))
->with('html_escape')->begin()
  ->isAllEscapedData('CommunityEvent', 'name')
  ->countEscapedData(1, 'Community', 'name', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
  ->countEscapedData(1, 'CommunityEvent', 'body', array(
    'width' => 36,
    'etc'   => '',
    'rows'  => 3,
  ))
->end()

->info('/communityEvent/_communityEventList, /communityTopic/_communityTopicList - XSS')
->get('/community/1055')
->with('html_escape')->begin()
  ->countEscapedData(1, 'CommunityEvent', 'name', array(
    'width' => 36,
  ))
  ->countEscapedData(1, 'CommunityTopic', 'name', array(
    'width' => 36,
  ))
->end()

->info('/communityEvent/_eventCommentListBox, /communityTopic/_topicCommentListBox - XSS')
->get('/')
->with('html_escape')->begin()
  ->isAllEscapedData('Community', 'name')
  ->countEscapedData(1, 'CommunityEvent', 'name', array(
    'width' => 36,
  ))
  ->countEscapedData(1, 'CommunityTopic', 'name', array(
    'width' => 36,
  ))
->end()
;
