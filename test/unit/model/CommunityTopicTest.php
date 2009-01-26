<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(84, new lime_output_color());

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
// CommunityTopic::isCreatableCommunityTopicComment()
//------------------------------------------------------------
$t->diag('CommunityTopic::isCreatableCommunityTopicComment()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$topic_a = CommunityTopicPeer::retrieveByPk(1);
$t->cmp_ok($topic_a->isCreatableCommunityTopicComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_a->isCreatableCommunityTopicComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_a->isCreatableCommunityTopicComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_a->isCreatableCommunityTopicComment(4), '===', false, 'returns false for a non-community member');
$topic_a = CommunityTopicPeer::retrieveByPk(5);
$t->cmp_ok($topic_a->isCreatableCommunityTopicComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_i = CommunityTopicPeer::retrieveByPk(2);
$t->cmp_ok($topic_i->isCreatableCommunityTopicComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_i->isCreatableCommunityTopicComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_i->isCreatableCommunityTopicComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_i->isCreatableCommunityTopicComment(4), '===', false, 'returns false for a non-community member');
$topic_i = CommunityTopicPeer::retrieveByPk(6);
$t->cmp_ok($topic_i->isCreatableCommunityTopicComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$topic_u = CommunityTopicPeer::retrieveByPk(3);
$t->cmp_ok($topic_u->isCreatableCommunityTopicComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_u->isCreatableCommunityTopicComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_u->isCreatableCommunityTopicComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_u->isCreatableCommunityTopicComment(4), '===', false, 'returns false for a non-community member');
$topic_u = CommunityTopicPeer::retrieveByPk(7);
$t->cmp_ok($topic_u->isCreatableCommunityTopicComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$topic_e = CommunityTopicPeer::retrieveByPk(4);
$t->cmp_ok($topic_e->isCreatableCommunityTopicComment(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_e->isCreatableCommunityTopicComment(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_e->isCreatableCommunityTopicComment(3), '===', true, 'returns true for a community member');
$t->cmp_ok($topic_e->isCreatableCommunityTopicComment(4), '===', false, 'returns false for a non-community member');
$topic_e = CommunityTopicPeer::retrieveByPk(8);
$t->cmp_ok($topic_e->isCreatableCommunityTopicComment(4), '===', false, 'returns false for the community topic author but a non-community member now');

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
// Community::isViewableCommunityTopic()
//------------------------------------------------------------
$t->diag('Community::isViewableCommunityTopic()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$community_a = CommunityPeer::retrieveByPk(1);
$t->cmp_ok($community_a->isViewableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_a->isViewableCommunityTopic(3), '===', true, 'returns true for a community member');
$t->cmp_ok($community_a->isViewableCommunityTopic(4), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$community_i = CommunityPeer::retrieveByPk(2);
$t->cmp_ok($community_i->isViewableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_i->isViewableCommunityTopic(3), '===', true, 'returns true for a community member');
$t->cmp_ok($community_i->isViewableCommunityTopic(4), '===', true, 'returns true for a non-community member');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$community_u = CommunityPeer::retrieveByPk(3);
$t->cmp_ok($community_u->isViewableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_u->isViewableCommunityTopic(3), '===', true, 'returns true for a community member');
$t->cmp_ok($community_u->isViewableCommunityTopic(4), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$community_e = CommunityPeer::retrieveByPk(4);
$t->cmp_ok($community_e->isViewableCommunityTopic(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($community_e->isViewableCommunityTopic(3), '===', true, 'returns true for a community member');
$t->cmp_ok($community_e->isViewableCommunityTopic(4), '===', true, 'returns true for a non-community member');

//------------------------------------------------------------
// CommunityTopicComment::isDeletable()
//------------------------------------------------------------
$t->diag('CommunityTopicComment::isDeletable()');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$topic_comment_a = CommunityTopicCommentPeer::retrieveByPk(1);
$t->cmp_ok($topic_comment_a->isDeletable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_comment_a->isDeletable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_comment_a->isDeletable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_comment_a->isDeletable(4), '===', false, 'returns false for a non-community member');
$t->cmp_ok($topic_comment_a->isDeletable(5), '===', true, 'returns true for the community topic comment author');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_comment_i = CommunityTopicCommentPeer::retrieveByPk(2);
$t->cmp_ok($topic_comment_i->isDeletable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_comment_i->isDeletable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_comment_i->isDeletable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_comment_i->isDeletable(4), '===', false, 'returns false for a non-community member');
$t->cmp_ok($topic_comment_i->isDeletable(5), '===', true, 'returns true for the community topic comment author');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: admin_only');
$topic_comment_u = CommunityTopicCommentPeer::retrieveByPk(3);
$t->cmp_ok($topic_comment_u->isDeletable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_comment_u->isDeletable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_comment_u->isDeletable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_comment_u->isDeletable(4), '===', false, 'returns false for a non-community member');
$t->cmp_ok($topic_comment_u->isDeletable(5), '===', true, 'returns true for the community topic comment author');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$topic_comment_e = CommunityTopicCommentPeer::retrieveByPk(4);
$t->cmp_ok($topic_comment_e->isDeletable(1), '===', true, 'returns true for the community admin');
$t->cmp_ok($topic_comment_e->isDeletable(2), '===', true, 'returns true for the community topic author');
$t->cmp_ok($topic_comment_e->isDeletable(3), '===', false, 'returns false for a community member');
$t->cmp_ok($topic_comment_e->isDeletable(4), '===', false, 'returns false for a non-community member');
$t->cmp_ok($topic_comment_e->isDeletable(5), '===', true, 'returns true for the community topic comment author');
