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
 * @subpackage action
 * @author     Shunsuke Watanabe <watanabe@craftgear.net>
 */
class communityEventActions extends opCommunityTopicPluginAPIActions
{
  public function preExecute()
  {
    parent::preExecute();

    $action = $this->getRequest()->getParameter('action');
    if ('join' == $action || 'memberList' == $action)
    {
      $this->forward400If(!$this->getRequest()->getParameter('id'), 'event id is not specified');
      $this->event = Doctrine::getTable('CommunityEvent')->findOneById($this->getRequest()->getParameter('id'));
      $this->forward400If(!$this->event, 'requested event does not exist');
    }

    $this->member = $this->getUser()->getMember();
    $this->memberId = $this->member->getId();
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->events = array();
    try
    {
      $target = $request->getParameter('target');
      $this->forward400If('topic' === $target, 'invalid target');
      $object = $this->getTargetObject($target, $request['target_id']);
      $options = $this->getOptions($request);

      if ('event' == $target)
      {
        $this->forward400If(!$this->isAllowed($object, $this->member, 'view'), 'you are not allowed to view event on this community');
        $this->events[] = $object;
        $this->count = 1;
      }
      else
      {
        if ('community' == $target)
        {
          $this->forward400If(!$this->isAllowed($object, $this->member, 'view'), 'you are not allowed to view event on this community');
        }
        elseif ('member' == $target)
        {
          $this->forward400If($this->member->getId() !== $object->getId(), 'this is not your member_id');
        }
        $pager = $this->getEventsPager($target, $request['target_id'], $options);
        $this->events = $pager->getResults();
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

  public function executeJoin(sfWebRequest $request)
  {
    $eventId = $request['id'];
    $this->forward400If(!$this->isAllowed($this->event, $this->getUser()->getMember(), 'addComment'), 'You are not allowed to join this event');
    $eventMember = Doctrine::getTable('CommunityEventMember')
      ->retrieveByEventIdAndMemberId($eventId, $this->member->getId());

    $flag = $request->getParameter('leave');
    if ($flag && 'true' === $flag)
    {
      if (!$eventMember)
      {
        $this->forward400('You can\'t leave this event.');
      }

      if ($this->event->isClosed())
      {
        $this->forward400('This event has already been finished.');
      }

      if ($this->event->isExpired())
      {
        $this->forward400('This event has already been expired.');
      }

      $eventMember->delete();
    }
    else
    {
      try
      {
        if ($eventMember)
        {
          throw new opCommunityTopicAPIRuntimeException('You are already this event member.');
        }
        $this->event->toggleEventMember($this->member->getId());
      }
      catch (RuntimeException $e)
      {
        $this->forward400($e->getMessage());
      }
    }
  }

  public function executeMemberList(sfWebRequest $request)
  {
    $this->forward400If(!$this->isAllowed($this->event, $this->getUser()->getMember(), 'view'), 'You are not allowed to view this event');
    $eventId = $request['id'];

    $this->eventMembers = Doctrine::getTable('Member')->createQuery('m')
      ->addWhere('EXISTS (FROM CommunityEventMember cem WHERE m.id = cem.member_id AND cem.community_event_id = ?)', $eventId)
      ->limit(200)
      ->execute();
  }

  public function executeDelete(sfWebRequest $request)
  {
    try
    {
      $event = $this->getTargetObject('event', $request['id']);
    }
    catch (opCommunityTopicAPIRuntimeException $e)
    {
      $this->forward400($e->getMessage());
    }

    $this->forward400If(!$event->isEditable($this->member->getId()), 'you are not allowed to delete this event');

    $isDeleted = $event->delete();

    if (!$isDeleted)
    {
      $this->forward400('failed to delete the entry. errorStack:'.$event->getErrorStackAsString());
    }

    $this->event = $event;
  }
}
