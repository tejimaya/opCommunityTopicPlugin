<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(null, new lime_output_color());

//------------------------------------------------------------
// Community::isCreatableCommunityTopic()
//------------------------------------------------------------
$t->diag('Community::isCreatableCommunityTopic()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$community_a = CommunityPeer::retrieveByPk(1);
$t->cmp_ok($community_a->isCreatableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_a->isCreatableCommunityTopic(3), '===', false, 'returns false for a community member');
$t->cmp_ok($community_a->isCreatableCommunityTopic(4), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$community_i = CommunityPeer::retrieveByPk(2);
$t->cmp_ok($community_i->isCreatableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_i->isCreatableCommunityTopic(3), '===', false, 'returns false for a community member');
$t->cmp_ok($community_i->isCreatableCommunityTopic(4), '===', false, 'returns false for a non-community member');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$community_u = CommunityPeer::retrieveByPk(3);
$t->cmp_ok($community_u->isCreatableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_u->isCreatableCommunityTopic(3), '===', true, 'returns true for a community member');
$t->cmp_ok($community_u->isCreatableCommunityTopic(4), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$community_e = CommunityPeer::retrieveByPk(4);
$t->cmp_ok($community_e->isCreatableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_e->isCreatableCommunityTopic(3), '===', true, 'returns true for a community member');
$t->cmp_ok($community_e->isCreatableCommunityTopic(4), '===', false, 'returns false for a non-community member');

