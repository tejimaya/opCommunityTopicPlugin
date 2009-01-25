<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(28, new lime_output_color());

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

//------------------------------------------------------------
// CommunityTopic::isCreatableComment()
//------------------------------------------------------------
$t->diag('CommunityTopic::isCreatableComment()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$topic_a = CommunityTopicPeer::retrieveByPk(1);
$t->cmp_ok($topic_a->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_a->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_a->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_a->isCreatableComment(4), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_i = CommunityTopicPeer::retrieveByPk(2);
$t->cmp_ok($topic_i->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_i->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_i->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_i->isCreatableComment(4), '===', false, 'returns false for a non-community member');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$topic_u = CommunityTopicPeer::retrieveByPk(3);
$t->cmp_ok($topic_u->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_u->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_u->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_u->isCreatableComment(4), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$topic_e = CommunityTopicPeer::retrieveByPk(4);
$t->cmp_ok($topic_e->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_e->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_e->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_e->isCreatableComment(4), '===', false, 'returns false for a non-community member');

