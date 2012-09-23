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
    $this->forward400If('' === (string)$request['community_id'], 'community_id parameter is not specified.');
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

    $this->topic = $topic;
  }

  public function executeSearch(sfWebRequest $request)
  {
    if ($request['format'] == 'mini')
    {
      $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'community id is not specified');

      $page = isset($request['page']) ? $request['page'] : 1;
      $limit = isset($request['limit']) ? $request['limit'] : sfConfig::get('op_json_api_limit', 15);

      $query = Doctrine::getTable('CommunityTopic')->createQuery('t')
        ->where('community_id = ?', $request['id'])
        ->orderBy('topic_updated_at desc')
        ->offset(($page - 1) * $limit)
        ->limit($limit);

      $this->topics = $query->execute();
      $total = $query->count();
      $this->next = false;
      if ($total > $page * $limit)
      {
        $this->next = $page + 1;
      }
    }
    else
    {
      $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'id is not specified');

      $this->memberId = $this->getUser()->getMemberId();
      $this->topic = Doctrine::getTable('CommunityTopic')->findOneById($request['id']);
    
      $this->setTemplate('show');
    }
  }

}
