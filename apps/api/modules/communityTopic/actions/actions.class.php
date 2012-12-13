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

    $this->topic = $topic;

  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['target']) || '' === (string)$request['target'], 'target is not specified');
    $limit = isset($request['count']) ? $request['count'] : sfConfig::get('op_json_api_limit', 15);

    if ($request['target'] == 'community')
    {
      $this->forward400If(!isset($request['target_id']) || '' === (string)$request['target_id'], 'community id is not specified');


      $query = Doctrine::getTable('CommunityTopic')->createQuery('t')
        ->where('community_id = ?', $request['target_id'])
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
    elseif($request['target'] == 'topic')
    {
      $this->forward400If(!isset($request['target_id']) || '' === (string)$request['target_id'], 'topic id is not specified');

      $topic = Doctrine::getTable('CommunityTopic')->findOneById($request['target_id']);

      $topic->actAs('opIsCreatableCommunityTopicBehavior');
      $this->forward400If(false === $topic->isViewableCommunityTopic($topic->getCommunity(), $this->member->getId()), 'you are not allowed to view topics on this community');
    
      $this->memberId = $this->getUser()->getMemberId();
      $this->topics = array($topic);
    }
    elseif ($request['target'] == 'member')
    {
      $this->forward400If(!isset($request['target_id']) || '' === (string)$request['target_id'], 'member id is not specified');
      $memberId = $request['target_id'];

      $communities = Doctrine::getTable('CommunityMember')->createQuery('q')
        ->select('community_id')
        ->where('member_id = ?', $memberId)
        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
        ->execute();
      
      $communityIds = array();
      foreach($communities as $_community)
      {
        array_push($communityIds, $_community['community_id']);
      }
    
      $topics = Doctrine::getTable('CommunityTopic')->createQuery('q')
        ->whereIn('community_id', $communityIds)
        ->orderBy('topic_updated_at desc')
        ->limit($limit)
        ->execute();

      $this->topics = $topics;
      $this->memberId = $memberId;
    }

    if (isset($request['format']) && $request['format'] == 'mini')
    {
      $this->setTemplate('searchMini');
    }
  }

}
