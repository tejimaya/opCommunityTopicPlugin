<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$t->info('should be able to post a new comment');
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
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->ok($data['data']['id'], 'should have an id');
$t->test()->ok($data['data']['member'], 'should have a member info');
$t->test()->is($data['data']['body'], $body, 'should have the same body posted');
$t->test()->ok($data['data']['created_at'], 'should have the date posted');

$t->info('non-members should NOT be able to post a new comment on communities with public_flag "auth_commu_member"');
$body = 'コメント本文';
$json = $t->post('/topic_comment/post.json',
    array(
      'apiKey'       => 'dummyApiKey4',
      'community_topic_id' => 1,
      'body'         => $body,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;

$t->info('non-members should NOT be able to post a new comment on communities with public_flag "public"');
$body = 'コメント本文';
$json = $t->post('/topic_comment/post.json',
    array(
      'apiKey'       => 'dummyApiKey4',
      'community_topic_id' => 32,
      'body'         => $body,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;
