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
    try
    {
      $topicId = $request->getParameter('id');
      $communityId = $request->getParameter('community_id');
      $this->isValidNameAndBody($request->getParameter('name'), $request->getParameter('body'));

      if($topicId)
      {
        $topic = $this->getTargetObject('topic', $topicId);
      }
      else
      {
        $this->forward400If(!$communityId, 'community_id parameter is not specified.');
        $topic = new CommunityTopic();
        $topic->setMemberId($this->member->getId());
        $topic->setCommunityId($communityId);
      }

      $this->forward400If(!$this->isAllowed($topic->getCommunity(), $this->member, 'add'), 'you are not allowed to create or update topics on this community');

      $topic->setName($request['name']);
      $topic->setBody($request['body']);
      $topic->save();
    }
    catch (opCommunityTopicAPIRuntimeException $e)
    {
      $this->forward400($e->getMessage());
    }

    opCommunityTopicToolkit::sendNotificationMail($topic);

    $this->topic = $topic;
  }

  public function executeDelete(sfWebRequest $request)
  {
    try
    {
      $topic = $this->getTargetObject('topic', $request['id']);
    }
    catch (opCommunityTopicAPIRuntimeException $e)
    {
      $this->forward400($e->getMessage());
    }

    $this->forward400If(!$topic->isEditable($this->member->getId()), 'you are not allowed to delete this topic');

    $isDeleted = $topic->delete();

    if (!$isDeleted)
    {
      $this->forward400('failed to delete the entry. errorStack:'.$topic->getErrorStackAsString());
    }

    $this->topic = $topic;
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->topics = array();
    try
    {
      $target = $request->getParameter('target');
      $this->forward400If('event' === $target, 'invalid target');
      $object = $this->getTargetObject($target, $request['target_id']);
      $options = $this->getOptions($request);

      if ('topic' == $target)
      {
        $this->forward400If(!$this->isAllowed($object, $this->member, 'view'), 'you are not allowed to view topic on this community');
        $this->topics[] = $object;
        $this->count = 1;
      }
      else
      {
        if ('community' == $target)
        {
          $this->forward400If(!$this->isAllowed($object, $this->member, 'view'), 'you are not allowed to view topic on this community');
        }
        elseif ('member' == $target)
        {
          $this->forward400If($this->member->getId() !== $object->getId(), 'this is not your member_id');
        }
        $pager = $this->getTopicsPager($target, $request['target_id'], $options);
        $this->topics = $pager->getResults();
        $this->count = $pager->count();
      }
    }
    catch (opCommunityTopicAPIRuntimeException $e)
    {
      $this->forward400($e->getMessage());
    }

    if (isset($request['format']) && $request['format'] == 'mini')
    {
      $this->setTemplate('searchMini');
    }
  }
}
