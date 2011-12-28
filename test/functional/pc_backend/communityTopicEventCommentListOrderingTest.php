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
  ->with('user')->isAuthenticated();

$browser->get('/communityTopic/topicList')
  ->with('request')->begin()
    ->isParameter('module', 'communityTopic')
    ->isParameter('action', 'topicList')
  ->end()
  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;

$browser->get('/communityTopic/eventList')
  ->with('request')->begin()
    ->isParameter('module', 'communityTopic')
    ->isParameter('action', 'eventList')
  ->end()
  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;

$browser->get('/communityTopic/topicCommentList')
  ->with('request')->begin()
    ->isParameter('module', 'communityTopic')
    ->isParameter('action', 'topicCommentList')
  ->end()
  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;

$browser->get('/communityTopic/eventCommentList')
  ->with('request')->begin()
    ->isParameter('module', 'communityTopic')
    ->isParameter('action', 'eventCommentList')
  ->end()
  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()
;