<?php

require_once __DIR__.'/../../bootstrap/unit.php';
require_once __DIR__.'/../../bootstrap/database.php';

$t = new lime_test(4);

$eventCommentTable = Doctrine_Core::getTable('CommunityEventComment');
$conn = $eventCommentTable->getConnection();

//------------------------------------------------------------
$t->diag('CommunityEventComment: Cascading Delete');
$conn->beginTransaction();

$eventComment = $eventCommentTable->find(1);
$eventCommentImage = $eventComment->Images[0];
$fileId = $eventCommentImage->file_id;

$eventComment->delete($conn);

$t->ok(!Doctrine_Core::getTable('CommunityEventComment')->find($eventComment->id), 'community_event_comment is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityEventCommentImage')->find($eventCommentImage->id), 'community_event_comment_image is deleted.');
$t->ok(!Doctrine_Core::getTable('File')->find($fileId), 'file is deleted.');
$t->ok(!Doctrine_Core::getTable('FileBin')->find($fileId), 'file_bin is deleted.');

$conn->rollback();
