<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$t->info('should return topics');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'target'    => 'community',
      'target_id' => 1,
      'format'    => 'mini',
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
$t->test()->ok($data['data'][1], 'topic 1 should have latest comment ');
$t->test()->is($data['data'][1]['latest_comment'], 'トピック a 10','latest comment of topic 1 should have body "トピック a 10"');

$t->info('should be able to limit numbers of topic by a parameter "count"');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'format'    => 'mini',
      'target'    => 'community',
      'target_id' => 1,
      'count'     => 5,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 5, 'should return 5 topics');

$t->info('should return topics with parameters, max_id and since_id');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'format'    => 'mini',
      'target'    => 'community',
      'target_id' => 1,
      'max_id'    => 3,
      'since_id'  => 1,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 2, 'should return 2 topics');
$t->test()->is($data['data'][0]['id'], '3', 'data 0 should have topic 3 ');
$t->test()->is($data['data'][1]['id'], '2', 'data 2 should have topic 2 ');


$t->info('should return a topic');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'target'    => 'topic',
      'target_id' => 1,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data'][0]['id'], '1', 'should return id 1');
$t->test()->is($data['data'][0]['community_id'], '1', 'should return community id 1');
$t->test()->is($data['data'][0]['name'], '_aトピ主', 'should return name _aトピ主');
$t->test()->is($data['data'][0]['body'], 'こんにちは', 'should return body こんにちは');


$t->info('non-members should NOT be able to read a topic on communities with public_flag "auth_cummu_member"');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey4',
      'target'    => 'topic',
      'target_id' => 1,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('non-members should be able to read a topic on communities with public_flag "public"');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey4',
      'target'    => 'topic',
      'target_id' => 32,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data'][0]['id'], '32', 'should return id 1');
$t->test()->is($data['data'][0]['community_id'], '2', 'should return community id 1');
$t->test()->is($data['data'][0]['name'], '_iトピ主', 'should return name _aトピ主');
$t->test()->is($data['data'][0]['body'], 'こんにちは', 'should return body こんにちは');


$t->info('should return member communities latest topics');
$json = $t->get('topic/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'target'    => 'member',
      'target_id' => 1,
      'count'     => 4,
      'format'    => 'mini',
    )
  )
  ->with('response')->begin()
    ->isStatusCode('200')
  ->end()
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 4, 'should return 4 topics');
$t->test()->ok($data['data'][1], 'topic 1 should have latest comment ');
$t->test()->is($data['data'][1]['latest_comment'], 'トピック i 10','latest comment of topic 1 should have body "トピック i 10"');
