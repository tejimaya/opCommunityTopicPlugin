<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

include dirname(__FILE__).'/../../bootstrap/database.php';

$topicId = 1;
$comments = Doctrine::getTable('CommunityTopicComment')
  ->createQuery('q')
  ->where('community_topic_id = ?', $topicId)
  ->execute();

$t->info('should fetch a list of comments ');
$json = $t->post('/topic_comment/search.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'community_topic_id' => $topicId,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), count($comments), 'should have '.count($comments).' comments');
$t->test()->ok(count($data['data'][0]['deletable']), 'should have deletable property');

$t->info('should be able to limit the number of comment');
$json = $t->post('/topic_comment/search.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'community_topic_id' => $topicId,
      'count' => 5
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 5, 'should have 5 comments');
$t->test()->ok(count($data['data'][0]['deletable']), 'should have deletable property');

$t->info('should return comments with parameters, max_id and since_id');
$json = $t->post('/topic_comment/search.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'community_topic_id' => $topicId,
      'max_id'    => 4,
      'since_id'  => 1,
    )
  )->getResponse()->getContent()
;
$data = json_decode($json, true);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 2, 'should return 2 topics');
$t->test()->is($data['data'][0]['id'], '4', 'data 0 should have topic 4 ');
$t->test()->is($data['data'][1]['id'], '2', 'data 2 should have topic 3 ');

$t->info('non-members should not be able to fetch a list of comments ');
$json = $t->post('/topic_comment/search.json',
    array(
      'apiKey'       => 'dummyApiKey4',
      'community_topic_id' => $topicId,
    )
  )
  ->with('response')->begin()
    ->isStatusCode('400')
  ->end()
;
