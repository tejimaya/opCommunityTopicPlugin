<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * community event api actions.
 *
 * @package    OpenPNE
 * @subpackage communityEventCommentActions
 * @author     Shunsuke Watanabe <watanabe@craftgear.net>
 * @author     tatsuya ichikawa <ichikawa@tejimaya.com>
 */
class communityEventCommentActions extends opCommunityTopicPluginAPIActions
{
  public function preExecute()
  {
    parent::preExecute();
    $action = $this->getRequest()->getParameter('action');
    if ('search' == $action || 'post' == $action)
    {
      $this->forward400If(!$this->getRequest()->getParameter('community_event_id'), 'community_event_id parameter is not specified.');
    }

    $this->member = $this->getUser()->getMember();
    $this->memberId = $this->member->getId();
  }

  public function executeSearch(sfWebRequest $request)
  {
    $event = $this->getViewableEvent($request['community_event_id'], $this->member);
    $options = $this->getOptions($request);

    $query = Doctrine::getTable('CommunityEventComment')->createQuery()
      ->where('community_event_id = ?', $event->getId())
      ->orderBy('created_at DESC');

    $this->count = $query->count();
    $this->comments = $this->getPager('CommunityEventComment', $query, $options)->getResults();
  }

  public function executePost(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['body'], 'body parameter is not specified.');
    if ($limit = sfConfig::get('app_smt_comment_post_limit'))
    {
      $this->forward400If(mb_strlen($request['body']) > $limit, 'body parameter is too long');
    }

    $comment = new CommunityEventComment();
    $comment->setMemberId($this->member->getId());
    $comment->setCommunityEventId($request['community_event_id']);

    $this->forward400If(false === $comment->getCommunityEvent()->isCreatableCommunityEventComment($this->member->getId()), 'you are not allowed to create comments on this event');

    $comment->setBody($request['body']);
    $comment->save();

    opCommunityTopicToolkit::sendNotificationMail($comment);

    $this->comment = $comment;
  }

  public function executeDelete(sfWebRequest $request)
  {
    $id = $request['id'];
    $this->forward400If('' === (string)$id, 'id parameter is not specified.');

    $comment = Doctrine::getTable('CommunityEventComment')->findOneById($id);

    $this->forward400If(false === $comment, 'the comment does not exist. id:'.$id);
    $this->forward400If(false === $comment->isDeletable($this->member->getId()), 'you can not delete this comment. id:'.$id);

    $isDeleted = $comment->delete();
    if ($isDeleted)
    {
      $this->comment = $comment;
    }
    else
    {
      $this->forward400('failed to delete the comment. errorStack:'.$comment->getErrorStackAsString());
    }
  }
}
