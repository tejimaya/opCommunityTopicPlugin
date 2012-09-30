<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$t->info('should return events');
$json = $t->get('event/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'target'    => 'community',
      'target_id' => 1,
      'format'    => 'mini'
    )
  )
  ->with('response')->begin()
    ->isstatuscode('200')
  ->end()
  ->getresponse()->getcontent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 15, 'should return 15 events');
$t->test()->ok($data['data'][0], 'event 0 should have latest comment ');
$t->test()->is($data['data'][0]['latest_comment'], 'こんにちは','latest comment of event 0 should have body "こんにちは"');

$t->info('should be able to limit numbers of event by a parameter "count"');
$json = $t->get('event/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'format'    => 'mini',
      'target'    => 'community',
      'target_id' => 1,
      'count'     => 5,
    )
  )
  ->with('response')->begin()
    ->isstatuscode('200')
  ->end()
  ->getresponse()->getcontent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 5, 'should return 5 events');

$t->info('should return events with parameters, max_id and since_id');
$json = $t->get('event/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'format'    => 'mini',
      'target'    => 'community',
      'target_id' => 1,
      'max_id'    => 4,
      'since_id'  => 1,
    )
  )
  ->with('response')->begin()
    ->isstatuscode('200')
  ->end()
  ->getresponse()->getcontent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 2, 'should return 2 events');
$t->test()->is($data['data'][0]['id'], '3', 'data 0 should have event 3 ');
$t->test()->is($data['data'][1]['id'], '4', 'data 1 should have event 4 ');


$t->info('should return a event');
$json = $t->get('event/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'target'    => 'event',
      'target_id' => 1,
    )
  )
  ->with('response')->begin()
    ->isstatuscode('200')
  ->end()
  ->getresponse()->getcontent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data'][0]['id'], '1', 'should return id 1');
$t->test()->is($data['data'][0]['community_id'], '1', 'should return community id 1');
$t->test()->is($data['data'][0]['name'], '_aイベ主', 'should return name _aトピ主');
$t->test()->is($data['data'][0]['body'], 'こんにちは', 'should return body こんにちは');
$t->test()->ok(is_array($data['data'][0]['images']), 'should have images property');


//$t->info('non-members should not be able to read a event on communities with public_flag "auth_cummu_member"');
//$json = $t->get('event/search.json',
    //array(
      //'apiKey'    => 'dummyApiKey4',
      //'target'    => 'event',
      //'target_id' => 1,
    //)
  //)
  //->with('response')->begin()
    //->isstatuscode('400')
  //->end()
//;

//$t->info('non-members should be able to read a event on communities with public_flag "public"');
//$json = $t->get('event/search.json',
    //array(
      //'apiKey'    => 'dummyApiKey4',
      //'target'    => 'event',
      //'target_id' => 32,
    //)
  //)
  //->with('response')->begin()
    //->isstatuscode('200')
  //->end()
  //->getresponse()->getcontent()
//;
//$data = json_decode($json, true);
//$t->test()->is($data['status'], 'success', 'should return status code "success"');
//$t->test()->is($data['data'][0]['id'], '32', 'should return id 1');
//$t->test()->is($data['data'][0]['community_id'], '2', 'should return community id 1');
//$t->test()->is($data['data'][0]['name'], '_iトピ主', 'should return name _aトピ主');
//$t->test()->is($data['data'][0]['body'], 'こんにちは', 'should return body こんにちは');


$t->info('should return member communities latest events');
$json = $t->get('event/search.json',
    array(
      'apiKey'    => 'dummyApiKey',
      'target'    => 'member',
      'target_id' => 1,
      'format'    => 'mini',
   )
  )
  ->with('response')->begin()
    ->isstatuscode('200')
  ->end()
  ->getresponse()->getcontent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 4, 'should return 4 events');
