<?php

ini_set('memory_limit', '1024M');

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$user = new opCommunityTopicTestFunctional(new sfBrowser(), new lime_test(null));

$user
->info('Begining scenarios of alien')
->info('public_flag: auth_commu_member, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'admin_only',
    ),
    'communityTopic' => array(
      'author' => 'admin',
    ),
    'communityTopicComment' => array(),
  )
)
->info('public_flag: public, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'admin_only',
    ),
    'communityTopic' => array(
      'author' => 'admin',
    ),
    'communityTopicComment' => array(),
  )
)
->info('public_flag: open, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'open',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'allow' => array('view'),
    ),
    'communityTopicComment' => array(),
  )
)
;

// create a test user: Mr_OpenPNE (community admin)
$user->login('sns@example.com', 'password');
$user
->info('Begining scenarios of community admin')
->info('public_flag: auth_commu_member, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'num' => 1,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
->info('public_flag: public, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'num' => 1,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
->info('public_flag: auth_commu_member, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'other',
      'num' => 2,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
->info('public_flag: public, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'other',
      'num' => 2,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
->scenario(
  array(
    'community' => array(
      'public_flag' => 'open',
      'topic_authority' => 'admin_only',
      'allow' => array('view')
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'num' => 1,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
;

include(dirname(__FILE__).'/../../bootstrap/database.php');
// create a test user: tanaka (topic author)
$user->login('tanaka@example.com', 'password');
$user
->info('Begining scenarios of topic author')
->info('public_flag: auth_commu_member, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'self',
      'num' => 2,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
->info('public_flag: public, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'self',
      'num' => 2,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
;

include(dirname(__FILE__).'/../../bootstrap/database.php');
// create a test user: sasaki (community member)
$user->login('sasaki@example.com', 'password');
$user
->info('Begining scenarios of community member')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'num' => 1,
      'allow' => array('view'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add'),
    ),
  )
)
->info('public_flag: public, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'num' => 1,
      'allow' => array('view'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add'),
    ),
  )
)
->info('public_flag: auth_commu_member, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'self',
      'num' => 2,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
->info('public_flag: public, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'self',
      'num' => 2,
      'allow' => array('view', 'update'),
    ),
    'communityTopicComment' => array(
      'allow' => array('add', 'delete'),
    ),
  )
)
;

include(dirname(__FILE__).'/../../bootstrap/database.php');
// create a test user: yamada (non-community member)
$user->login('yamada@example.com', 'password');
$user
->info('Begining scenarios of non-community member')
->info('public_flag: auth_commu_member, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
  )
)
->info('public_flag: public, topic_authority: admin_only')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'admin_only',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'admin',
      'num' => 1,
      'allow' => array('view'),
    ),
  )
)
->info('public_flag: auth_commu_member, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'auth_commu_member',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
  )
)
->info('public_flag: public, topic_authority: public')
->scenario(
  array(
    'community' => array(
      'public_flag' => 'public',
      'topic_authority' => 'public',
      'allow' => array('view'),
    ),
    'communityTopic' => array(
      'author' => 'other',
      'num' => 2,
      'allow' => array('view'),
    ),
  )
)
;
