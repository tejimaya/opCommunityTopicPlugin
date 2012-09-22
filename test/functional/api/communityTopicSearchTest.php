<?php

include dirname(__FILE__).'/../../bootstrap/functional.php';

$t = new opTestFunctional(new sfBrowser());

//include dirname(__FILE__).'/../../bootstrap/database.php';

$mailAddress = 'sns1@example.com';

$t->login($mailAddress, 'password');
$t->setCulture('en');

$t->info('should return topics');
$json = $t->get('topic/search.json',
    array(
      'apiKey'       => 'dummyApiKey',
      'format'       => 'mini',
      'community_id' => 1
    )
  )
  ->getResponse()->getContent()
;
$data = json_decode($json, true);
var_dump($data);
$t->test()->is($data['status'], 'success', 'should return status code "success"');
$t->test()->is(count($data['data']), 15, 'should return 15 topics');
$t->test()->is($data['next'], 2, 'should return next page number 2 ');
