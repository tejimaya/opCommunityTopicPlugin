<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * community topic api actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Shunsuke Watanabe <watanabe@craftgear.net>
 */
class communityTopicActions extends opJsonApiActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->member = $this->getUser()->getMember();
  }

  public function executePost(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['id'] && '' === (string)$request['community_id'], 'community_id parameter is not specified.');
    $this->forward400If('' === (string)$request['name'], 'name parameter is not specified.');
    $this->forward400If('' === (string)$request['body'], 'body parameter is not specified.');

    if(isset($request['id']) && '' !== $request['id'])
    {
      $topic = Doctrine::getTable('CommunityTopic')->findOneById($request['id']);
      $this->forward400If(false === $topic, 'the specified topic does not exit.');
      $this->forward400If(false === $topic->isEditable($this->member->getId()), 'this topic is not yours.');
    }
    else
    {
      $topic = new CommunityTopic();
      $topic->setMemberId($this->member->getId());
      $topic->setCommunityId($request['community_id']);
    }

    $topic->actAs('opIsCreatableCommunityTopicBehavior');
    $this->forward400If(false === $topic->isCreatableCommunityTopic($topic->getCommunity(), $this->member->getId()), 'you are not allowed to create or update topics on this community');

    $topic->setName($request['name']);
    $topic->setBody($request['body']);
    $topic->save();

    $this->memberId = $this->getUser()->getMemberId();
    $this->topic = $topic;
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'a topic id is not specified');

    $topic = Doctrine::getTable('CommunityTopic')->findOneById($request['id']);
    $this->forward400If(false === $topic->isEditable($this->member->getId()), 'this topic is not yours.');

    $isDeleted = $topic->delete();

    if (!$isDeleted)
    {
      $this->forward400('failed to delete the entry. errorStack:'.$topic->getErrorStackAsString());
    }

  }

  public function executeSearch(sfWebRequest $request)
  {
    if ($request['format'] == 'mini')
    {
      $this->forward400If(!isset($request['community_id']) || '' === (string)$request['community_id'], 'community id is not specified');

      $limit = isset($request['count']) ? $request['count'] : sfConfig::get('op_json_api_limit', 15);

      $query = Doctrine::getTable('CommunityTopic')->createQuery('t')
        ->where('community_id = ?', $request['community_id'])
        ->orderBy('topic_updated_at desc')
        ->limit($limit);

      if(isset($request['max_id']))
      {
        $query->addWhere('id <= ?', $request['max_id']);
      }

      if(isset($request['since_id']))
      {
        $query->addWhere('id > ?', $request['since_id']);
      }

      $this->topics = $query->execute();
      $total = $query->count();
    }
    else
    {
      $this->forward400If(!isset($request['topic_id']) || '' === (string)$request['topic_id'], 'topic id is not specified');

      $topic = Doctrine::getTable('CommunityTopic')->findOneById($request['topic_id']);

      $topic->actAs('opIsCreatableCommunityTopicBehavior');
      $this->forward400If(false === $topic->isViewableCommunityTopic($topic->getCommunity(), $this->member->getId()), 'you are not allowed to view topics on this community');
    
      $this->memberId = $this->getUser()->getMemberId();
      $this->topics = array($topic);
    }
  }

}
