<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

//include dirname(__FILE__).'/../../bootstrap/database.php';

$t->info('should return topics');
$json = $t->get('topic/search.json',
    array(
      'apiKey' => 'dummyApiKey',
      'format' => 'mini',
      'community_id'     => 1
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 15, 'should return 15 topics');
$t->test()->is($data['next'], 2, 'should return next page number 2 ');
$t->test()->ok($data['data'][1], 'topic 1 should have latest comment ');
$t->test()->is($data['data'][1]['latest_comment'], 'トピック a 10','latest comment of topic 1 should have body "トピック a 10"');

$t->info('should return a topic');
$json = $t->get('topic/search.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'topic_id' => 1
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['id'], '1', 'should return id 1');
$t->test()->is($data['data']['community_id'], '1', 'should return community id 1');
$t->test()->is($data['data']['name'], '_aトピ主', 'should return name _aトピ主');
$t->test()->is($data['data']['body'], 'こんにちは', 'should return body こんにちは');


$t->info('non-members should NOT be able to read a topic on communities with public_flag "auth_cummu_member"');
$json = $t->get('topic/search.json',
    array(
      'apiKey' => 'dummyApiKey4',
      'topic_id'     => 1
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('non-members should be able to read a topic on communities with public_flag "public"');
$json = $t->get('topic/search.json',
    array(
      'apiKey' => 'dummyApiKey4',
      'topic_id'     => 32
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['id'], '32', 'should return id 1');
$t->test()->is($data['data']['community_id'], '2', 'should return community id 1');
$t->test()->is($data['data']['name'], '_iトピ主', 'should return name _aトピ主');
$t->test()->is($data['data']['body'], 'こんにちは', 'should return body こんにちは');
