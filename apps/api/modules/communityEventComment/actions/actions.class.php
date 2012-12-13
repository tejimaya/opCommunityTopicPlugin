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
class communityEventCommentActions extends opJsonApiActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->member = $this->getUser()->getMember();
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['community_event_id'], 'community_event_id parameter is not specified.');

    $event = Doctrine::getTable('CommunityEvent')->findOneById($request['community_event_id']);

    $event->actAs('opIsCreatableCommunityTopicBehavior');
    $this->forward400If(false === $event->isViewableCommunityTopic($event->getCommunity(), $this->member->getId()), 'you are not allowed to view this event and comments on this community');

    $limit = isset($request['count']) ? $request['count'] : sfConfig::get('op_json_api_limit', 15);

    $query = Doctrine::getTable('CommunityEventComment')->createQuery('c')
      ->where('community_event_id = ?', $event->getId())
      ->orderBy('created_at desc')
      ->limit($limit);

    if(isset($request['max_id']))
    {
      $query->addWhere('id <= ?', $request['max_id']);
    }

    if(isset($request['since_id']))
    {
      $query->addWhere('id > ?', $request['since_id']);
    }

    $this->memberId = $this->getUser()->getMemberId();
    $this->comments = $query->execute();

  }

  public function executePost(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['community_event_id'], 'community_event_id parameter is not specified.');
    $this->forward400If('' === (string)$request['body'], 'body parameter is not specified.');

    $comment = new CommunityEventComment();
    $comment->setMemberId($this->member->getId());
    $comment->setCommunityEventId($request['community_event_id']);

    $this->forward400If(false === $comment->getCommunityEvent()->isCreatableCommunityEventComment($this->member->getId()), 'you are not allowed to create comments on this event');

    $comment->setBody($request['body']);
    $comment->save();

    $this->memberId = $this->getUser()->getMemberId();
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
