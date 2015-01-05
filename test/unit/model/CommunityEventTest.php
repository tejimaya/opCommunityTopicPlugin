<?php

require_once __DIR__.'/../../bootstrap/unit.php';
require_once __DIR__.'/../../bootstrap/database.php';

$t = new lime_test(8);

//------------------------------------------------------------
$t->diag('CommunityEvent: Cascading Delete');
$conn->beginTransaction();

$event = Doctrine_Core::getTable('CommunityEvent')->find(1);
$eventImage = $event->Images[0];
$file1Id = $eventImage->file_id;
$eventComment = Doctrine_Core::getTable('CommunityEventComment')->find(1);
$eventCommentImage = $eventComment->Images[0];
$file2Id = $eventCommentImage->file_id;

/*
 * community_event
 *  |- community_event_image
 *  |   +- file
 *  |       +- file_bin
 *  +- community_event_comment
 *      +- community_event_comment_image
 *          +- file
 *              +- file_bin
 */
$event->delete($conn);

$t->ok(!Doctrine_Core::getTable('CommunityEvent')->find($event->id), 'community_event is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityEventImage')->find($eventImage->id), 'community_event_image is deleted.');
$t->ok(!Doctrine_Core::getTable('File')->find($file1Id), 'file is deleted.');
$t->ok(!Doctrine_Core::getTable('FileBin')->find($file1Id), 'file_bin is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityEventComment')->find($eventComment->id), 'community_event_comment is deleted.');
$t->ok(!Doctrine_Core::getTable('CommunityEventCommentImage')->find($eventCommentImage->id), 'community_event_comment_image is deleted.');
$t->ok(!Doctrine_Core::getTable('File')->find($file2Id), 'file is deleted.');
$t->ok(!Doctrine_Core::getTable('FileBin')->find($file2Id), 'file_bin is deleted.');

$conn->rollback();
