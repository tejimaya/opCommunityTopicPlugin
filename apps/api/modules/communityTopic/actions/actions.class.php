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
class communityTopicActions extends opCommunityTopicPluginAPIActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->member = $this->getUser()->getMember();
    $this->memberId = $this->member->getId();
  }

  public function executePost(sfWebRequest $request)
  {
    $this->forward400If('' === (string)$request['id'] && '' === (string)$request['community_id'], 'community_id parameter is not specified.');
    $this->isValidNameAndBody($request);

    if(isset($request['id']) && '' !== $request['id'])
    {
      $topic = $this->getTopicByTopicId($request['id']);
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

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'a topic id is not specified');

    $topic = $this->getTopicByTopicId($request['id']);
    $isDeleted = $topic->delete();

    if (!$isDeleted)
    {
      $this->forward400('failed to delete the entry. errorStack:'.$topic->getErrorStackAsString());
    }

    $this->topic = $topic;
  }

  public function executeSearch(sfWebRequest $request)
  {
    try
    {
      $target = $this->getValidTarget($request);
      $options = $this->getOptions($request);
      $this->topics = $this->getTopics($target, $request['target_id'], $options);
    }
    catch (Exception $e)
    {
      $this->forward400($e->getMessage());
    }

    if (isset($request['format']) && $request['format'] == 'mini')
    {
      $this->setTemplate('searchMini');
    }
  }
}
