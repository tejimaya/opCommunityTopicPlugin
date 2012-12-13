<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$t->info('should be able to delete his or her own comment');
$body = 'コメント本文';
$json = $t->post('/topic_comment/post.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'community_topic_id' => 1,
      'body'         => $body,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$postedCommentId = $data['data']['id'];

$json = $t->post('/topic_comment/delete.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'id' => $postedCommentId,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->ok($data['data']['id'], 'should have the same id deleted');
$t->test()->ok($data['data']['member'], 'should have a member info');
$t->test()->is($data['data']['body'], $body, 'should have the same body deleted');
$t->test()->ok($data['data']['created_at'], 'should have the date deleted');


$t->info('topic owners should be able to delete comments on his or her own topics');
$name = '自分のトピックタイトル';
$body = '自分のトピック本文';
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

$body = '他メンバーのコメント本文';
$json = $t->post('/topic_comment/post.json',
    array(
      'apiKey'       => 'dummyApiKey2',
      'community_topic_id' => $postedTopicId,
      'body'         => $body,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$postedCommentId = $data['data']['id'];

$json = $t->post('/topic_comment/delete.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'id' => $postedCommentId,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->ok($data['data']['id'], 'should have the same id deleted');
$t->test()->ok($data['data']['member'], 'should have a member info');
$t->test()->is($data['data']['body'], $body, 'should have the same body deleted');
$t->test()->ok($data['data']['created_at'], 'should have the date deleted');

$t->info('should NOT be able to delete other\'s comments');
$body = '他メンバーのコメント本文';
$json = $t->post('/topic_comment/post.json',
    array(
      'apiKey'       => 'dummyApiKey2',
      'community_topic_id' => 1,
      'body'         => $body,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$postedCommentId = $data['data']['id'];

$json = $t->post('/topic_comment/delete.json',
    array(
      'apiKey'       => 'dummyApiKey3',
      'id' => $postedCommentId,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;
