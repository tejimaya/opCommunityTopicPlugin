<?php

include(dirname(__FILE__).'/../../bootstrap/unit.php');
include(dirname(__FILE__).'/../../bootstrap/database.php');

$t = new lime_test(72);

$members = Doctrine::getTable('Member')->createQuery()->orderBy('id')->execute();
$communities = Doctrine::getTable('Community')->createQuery()->orderBy('id')->execute();
$topics = Doctrine::getTable('CommunityTopic')->createQuery()->orderBy('id')->execute();

function getAcl($object)
{
  global $members;
  switch(get_class($object))
  {
    case 'Community':
      return opCommunityTopicAclBuilder::buildCollection($object, $members);
    case 'CommunityTopic':
      return opCommunityTopicAclBuilder::buildResource($object, $members);
  }
}

//------------------------------------------------------------
// Is the community creatable topics
//------------------------------------------------------------
$t->diag('Is the community creatable a topic)');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$acl = getAcl($communities[0]);
$t->cmp_ok($acl->isAllowed(1, null, 'add'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'add'), '===', false, 'returns false for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'add'), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$acl = getAcl($communities[1]);
$t->cmp_ok($acl->isAllowed(1, null, 'add'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'add'), '===', false, 'returns false for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'add'), '===', false, 'returns false for a non-community member');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$acl = getAcl($communities[2]);
$t->cmp_ok($acl->isAllowed(1, null, 'add'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'add'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'add'), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$acl = getAcl($communities[3]);
$t->cmp_ok($acl->isAllowed(1, null, 'add'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'add'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'add'), '===', false, 'returns false for a non-community member');

//------------------------------------------------------------
// Is the community topic creatable comments
//------------------------------------------------------------
$t->diag('Is the community topic creatable comments');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$acl = getAcl($topics[0]);
$t->cmp_ok($acl->isAllowed(1, null, 'addComment'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'addComment'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'addComment'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[4]);
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$acl = getAcl($topics[2]);
$t->cmp_ok($acl->isAllowed(1, null, 'addComment'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'addComment'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'addComment'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[5]);
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$acl = getAcl($topics[3]);
$t->cmp_ok($acl->isAllowed(1, null, 'addComment'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'addComment'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'addComment'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[6]);
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$acl = getAcl($topics[4]);
$t->cmp_ok($acl->isAllowed(1, null, 'addComment'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'addComment'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'addComment'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[7]);
$t->cmp_ok($acl->isAllowed(4, null, 'addComment'), '===', false, 'returns false for the community topic author but a non-community member now');

//------------------------------------------------------------
// Is the community topic editable
//------------------------------------------------------------
$t->diag('Is the community topic editable');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$acl = getAcl($topics[0]);
$t->cmp_ok($acl->isAllowed(1, null, 'edit'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'edit'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'edit'), '===', false, 'returns false for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[4]);
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$acl = getAcl($topics[1]);
$t->cmp_ok($acl->isAllowed(1, null, 'edit'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'edit'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'edit'), '===', false, 'returns false for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[5]);
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$acl = getAcl($topics[2]);
$t->cmp_ok($acl->isAllowed(1, null, 'edit'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'edit'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'edit'), '===', false, 'returns false for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[6]);
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for the community topic author but a non-community member now');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$acl = getAcl($topics[3]);
$t->cmp_ok($acl->isAllowed(1, null, 'edit'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(2, null, 'edit'), '===', true, 'returns true for the community topic author');
$t->cmp_ok($acl->isAllowed(3, null, 'edit'), '===', false, 'returns false for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for a non-community member');
$acl = getAcl($topics[7]);
$t->cmp_ok($acl->isAllowed(4, null, 'edit'), '===', false, 'returns false for the community topic author but a non-community member now');

//------------------------------------------------------------
// Is the community viewable that topics
//------------------------------------------------------------
$t->diag('Is the community viewable that topics');

// * public_flag:     auth_commu_member
// * topic_authority: admin_only
$t->diag('public_flag: auth_commu_member, topic_authority: admin_only');
$acl = getAcl($communities[0]);
$t->cmp_ok($acl->isAllowed(1, null, 'view'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'view'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'view'), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: admin_only
$t->diag('public_flag: public, topic_authority: admin_only');
$acl = getAcl($communities[1]);
$t->cmp_ok($acl->isAllowed(1, null, 'view'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'view'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'view'), '===', true, 'returns true for a non-community member');

// * public_flag:     auth_commu_member
// * topic_authority: public
$t->diag('public_flag: auth_commu_member, topic_authority: public');
$acl = getAcl($communities[2]);
$t->cmp_ok($acl->isAllowed(1, null, 'view'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'view'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'view'), '===', false, 'returns false for a non-community member');

// * public_flag:     public
// * topic_authority: public
$t->diag('public_flag: public, topic_authority: public');
$acl = getAcl($communities[3]);
$t->cmp_ok($acl->isAllowed(1, null, 'view'), '===', true, 'returns true for the community admin');
$t->cmp_ok($acl->isAllowed(3, null, 'view'), '===', true, 'returns true for a community member');
$t->cmp_ok($acl->isAllowed(4, null, 'view'), '===', true, 'returns true for a non-community member');

//------------------------------------------------------------
$t->diag('CommunityTopic: Cascading Delete');
$conn->beginTransaction();

$topic = Doctrine_Core::getTable('CommunityTopic')->find(1);
$topicImage = $topic->Images[0];
$file1Id = $topicImage->file_id;
$topicComment = Doctrine_Core::getTable('CommunityTopicComment')->find(1);
$topicCommentImage = $topicComment->Images[0];
$file2Id = $topicCommentImage->file_id;

/*
 * community_topic
 *  |- community_topic_image
 *  |   +- file
 *  |       +- file_bin
 *  +- community_topic_comment
 *      +- community_topic_comment_image
 *          +- file
 *              +- file_bin
 */
$topic->delete($conn);

$t->ok(!Doctrine_Core::getTable('CommunityTopic')->find($topic->id), 'community_topic is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityTopicImage')->find($topicImage->id), 'community_topic_image is deleted.');
$t->ok(!Doctrine_Core::getTable('File')->find($file1Id), 'file is deleted.');
$t->ok(!Doctrine_Core::getTable('FileBin')->find($file1Id), 'file_bin is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityTopicComment')->find($topicComment->id), 'community_topic_comment is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityTopicCommentImage')->find($topicCommentImage->id), 'community_topic_comment_image is deleted.');
$t->ok(!Doctrine_Core::getTable('File')->find($file2Id), 'file is deleted.');
$t->ok(!Doctrine_Core::getTable('FileBin')->find($file2Id), 'file_bin is deleted.');

$conn->rollback();
