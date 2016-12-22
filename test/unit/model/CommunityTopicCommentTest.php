<?php

require_once __DIR__.'/../../bootstrap/unit.php';
require_once __DIR__.'/../../bootstrap/database.php';

$t = new lime_test(4);

$topicCommentTable = Doctrine_Core::getTable('CommunityTopicComment');
$conn = $topicCommentTable->getConnection();

//------------------------------------------------------------
$t->diag('CommunityTopicComment: Cascading Delete');
$conn->beginTransaction();

$topicComment = $topicCommentTable->find(1);
$topicCommentImage = $topicComment->Images[0];
$fileId = $topicCommentImage->file_id;

$topicComment->delete($conn);

$t->ok(!Doctrine_Core::getTable('CommunityTopicComment')->find($topicComment->id), 'community_topic_comment is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityTopicCommentImage')->find($topicCommentImage->id), 'community_topic_comment_image is deleted.');
$t->ok(!Doctrine_Core::getTable('File')->find($fileId), 'file is deleted.');
$t->ok(!Doctrine_Core::getTable('FileBin')->find($fileId), 'file_bin is deleted.');

$conn->rollback();
