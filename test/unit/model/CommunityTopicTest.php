<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(null, new lime_output_color());

//------------------------------------------------------------
// CommunityTopicPeer::isCreatable()
// * コミュニティ設定
//   * public_flag:     auth_commu_member
//   * topic_authority: admin_only
//------------------------------------------------------------

// $t->diag('CommunityTopic::isCreatable()');
// $t->isa_ok(CommunityTopicPeer::isCreatable(1, 1), 'community admin',
