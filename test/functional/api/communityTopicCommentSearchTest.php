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
$t->test()->is(count($data['data']['comments']), count($comments), 'should have '.count($comments).' comments');
$t->test()->ok(count($data['data']['comments'][0]['deletable']), 'should have deletable property');

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
