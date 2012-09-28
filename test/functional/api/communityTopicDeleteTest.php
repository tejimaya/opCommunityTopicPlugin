<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$t->info('should be able to post a new topic');
$name = 'テストタイトル';
$body = 'テスト本文';
$json = $t->post('/topic/post.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'community_id' => 1,
      'name'         => $name,
      'body'         => $body,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$postedTopicId = $data['data']['id'];

$t->info('others should NOT be able to delete other\'s  topic');
$json = $t->post('/topic/delete.json',
    array(
      'apiKey'       => 'dummyApiKey2',
      'id'           => $postedTopicId,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('the author should be able to delete his or her own topic');
$json = $t->post('/topic/delete.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'id'           => $postedTopicId,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['id'], $postedTopicId, 'should have the samme id');
$t->test()->ok($data['data']['community_id'], 'should have a community id');
$t->test()->ok($data['data']['member'], 'should have a member info');
$t->test()->is($data['data']['name'], $name, 'should have the same name deleted');
$t->test()->is($data['data']['body'], $body, 'should have the same body deleted');
$t->test()->ok($data['data']['created_at'], 'should have the date deleted');
