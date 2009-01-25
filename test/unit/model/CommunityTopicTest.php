<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(72, new lime_output_color());

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
$topic_a = CommunityTopicPeer::retrieveByPk(5);
$t->cmp_ok($topic_a->isCreatableComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_i = CommunityTopicPeer::retrieveByPk(2);
$t->cmp_ok($topic_i->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_i->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_i->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_i->isCreatableComment(4), '===', false, 'returns false for a non-community member');
$topic_i = CommunityTopicPeer::retrieveByPk(6);
$t->cmp_ok($topic_i->isCreatableComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$topic_u = CommunityTopicPeer::retrieveByPk(3);
$t->cmp_ok($topic_u->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_u->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_u->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_u->isCreatableComment(4), '===', false, 'returns false for a non-community member');
$topic_u = CommunityTopicPeer::retrieveByPk(7);
$t->cmp_ok($topic_u->isCreatableComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$topic_e = CommunityTopicPeer::retrieveByPk(4);
$t->cmp_ok($topic_e->isCreatableComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_e->isCreatableComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_e->isCreatableComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_e->isCreatableComment(4), '===', false, 'returns false for a non-community member');
$topic_e = CommunityTopicPeer::retrieveByPk(8);
$t->cmp_ok($topic_e->isCreatableComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

//------------------------------------------------------------
// CommunityTopic::isEditable()
//------------------------------------------------------------
$t->diag('CommunityTopic::isEditable()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$topic_a = CommunityTopicPeer::retrieveByPk(1);
$t->cmp_ok($topic_a->isEditable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_a->isEditable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_a->isEditable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_a->isEditable(4), '===', false, 'returns false for a non-community member');
$topic_a = CommunityTopicPeer::retrieveByPk(5);
$t->cmp_ok($topic_a->isEditable(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_i = CommunityTopicPeer::retrieveByPk(2);
$t->cmp_ok($topic_i->isEditable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_i->isEditable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_i->isEditable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_i->isEditable(4), '===', false, 'returns false for a non-community member');
$topic_i = CommunityTopicPeer::retrieveByPk(6);
$t->cmp_ok($topic_i->isEditable(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$topic_u = CommunityTopicPeer::retrieveByPk(3);
$t->cmp_ok($topic_u->isEditable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_u->isEditable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_u->isEditable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_u->isEditable(4), '===', false, 'returns false for a non-community member');
$topic_u = CommunityTopicPeer::retrieveByPk(7);
$t->cmp_ok($topic_u->isEditable(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$topic_e = CommunityTopicPeer::retrieveByPk(4);
$t->cmp_ok($topic_e->isEditable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_e->isEditable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_e->isEditable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_e->isEditable(4), '===', false, 'returns false for a non-community member');
$topic_e = CommunityTopicPeer::retrieveByPk(8);
$t->cmp_ok($topic_e->isEditable(4), '===', false, 'returns false for the community topic author but a non-community member now');

//------------------------------------------------------------
// CommunityTopic::isViewable()
//------------------------------------------------------------
$t->diag('CommunityTopic::isViewable()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$topic_a = CommunityTopicPeer::retrieveByPk(1);
$t->cmp_ok($topic_a->isViewable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_a->isViewable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_a->isViewable(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_a->isViewable(4), '===', false, 'returns false for a non-community member');
$topic_a = CommunityTopicPeer::retrieveByPk(5);
$t->cmp_ok($topic_a->isViewable(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_i = CommunityTopicPeer::retrieveByPk(2);
$t->cmp_ok($topic_i->isViewable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_i->isViewable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_i->isViewable(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_i->isViewable(4), '===', true, 'returns true for a non-community member');
$topic_i = CommunityTopicPeer::retrieveByPk(6);
$t->cmp_ok($topic_i->isViewable(4), '===', true, 'returns true for the community topic author but a non-community member now');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$topic_u = CommunityTopicPeer::retrieveByPk(3);
$t->cmp_ok($topic_u->isViewable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_u->isViewable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_u->isViewable(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_u->isViewable(4), '===', false, 'returns false for a non-community member');
$topic_u = CommunityTopicPeer::retrieveByPk(7);
$t->cmp_ok($topic_u->isViewable(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$topic_e = CommunityTopicPeer::retrieveByPk(4);
$t->cmp_ok($topic_e->isViewable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_e->isViewable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_e->isViewable(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_e->isViewable(4), '===', true, 'returns true for a non-community member');
$topic_e = CommunityTopicPeer::retrieveByPk(8);
$t->cmp_ok($topic_e->isViewable(4), '===', true, 'returns true for the community topic author but a non-community member now');

