<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communitEventCommentActions
 *
 * @package    opCommunityTopicPlugin
 * @subpackage communityEventComment
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class communityEventCommentActions extends opCommunityTopicPluginMailActions
{
  public function executeCreate(opMailRequest $request)
  {
    $member = $this->getRoute()->getMember();
    if (!$member)
    {
      return sfView::NONE;
    }

    $topic = Doctrine::getTable('CommunityEvent')->find($request['id']);
    if (!$topic || !$topic->isCreatableCommunityEventComment($member->id))
    {
      return sfView::NONE;
    }

    if ($topic->member_id !== $member->id)
    {
      $relation = Doctrine::getTable('MemberRelationship')->retrieveByFromAndTo($topic->member_id, $member->id);
      if ($relation && $relation->getIsAccessBlock())
      {
        return sfView::NONE;
      }
    }

    $mailMessage = $request->getMailMessage();

    $validator = new opValidatorString(array('rtrim' => true));
    try
    {
      $body = $validator->clean($mailMessage->getContent());
    }
    catch (Exception $e)
    {
      return sfView::ERROR;
    }

    $topicComment = new CommunityEventComment();
    $topicComment->setCommunityEvent($topic);
    $topicComment->setMember($member);
    $topicComment->setBody($body);

    $topicComment->save();

    $num = (int)sfConfig::get('app_community_topic_comment_max_image_file_num', 3);
    $files = $this->getImageFiles($mailMessage, $num);

    $number = 0;
    foreach ($files as $file)
    {
      $number++;
      $image = new CommunityEventCommentImage();
      $image->setCommunityEventComment($topicComment);
      $image->setFile($file);
      $image->setNumber($number);

      $image->save();
    }

    opCommunityTopicToolkit::sendNotificationMail($topic->getCommunity(), $topic->getId(), 'event', $topicComment->getMember()->getName(), $topic->getName(), $topicComment->getBody());

    return sfView::NONE;
  }
}
