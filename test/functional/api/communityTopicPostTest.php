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
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->ok($data['data']['id'], 'should have an id');
$t->test()->ok($data['data']['community_id'], 'should have a community id');
$t->test()->ok($data['data']['member'], 'should have a member info');
$t->test()->is($data['data']['name'], $name, 'should have the same name posted');
$t->test()->is($data['data']['body'], $body, 'should have the same body posted');
$t->test()->ok($data['data']['created_at'], 'should have the date posted');
$postedTopicId = $data['data']['id'];

$t->info('the author should be able to edit his or her own topic');
$name = '編集後のタイトル';
$body = '編集後の本文';
$json = $t->post('/topic/post.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'id'           => $postedTopicId,
      'name'         => $name,
      'body'         => $body,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['name'], $name, 'should have the same name posted');
$t->test()->is($data['data']['body'], $body, 'should have the same body posted');

$t->info('others should NOT be able to edit other\'s  topic');
$name = '編集できないタイトル';
$body = '編集できない本文';
$json = $t->post('/topic/post.json',
    array(
      'apiKey'       => 'dummyApiKey2',
      'id'           => $postedTopicId,
      'name'         => $name,
      'body'         => $body,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('members should NOT be able to post a new topic on communities with topic_authority "admin_only"');
$name = '投稿できないタイトル';
$body = '投稿できない本文';
$json = $t->post('/topic/post.json',
    array(
      'apiKey'       => 'dummyApiKey2',
      'community_id' => 1,
      'name'         => $name,
      'body'         => $body,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;


$t->info('members should be able to post a new topic on communities with topic_authority "public"');
$name = '投稿できるタイトル';
$body = '投稿できる本文';
$json = $t->post('/topic/post.json',
    array(
      'apiKey'       => 'dummyApiKey2',
      'community_id' => 3,
      'name'         => $name,
      'body'         => $body,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is($data['data']['name'], $name, 'should have the same name posted');
$t->test()->is($data['data']['body'], $body, 'should have the same body posted');


