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
    $this->member = $this->getUser()->getMember();
  }

  public function executeSearch(sfWebRequest $request)
  {
    try
    {
      $target = $this->getValidTarget($request);
    }
    catch (Exception $e)
    {
      $this->forward400($e->getMessage());
    }
    $options = $this->getOptions($request);
    $this->memberId = $this->member->getId();
    $this->events = $this->getEvents($target, $request['target_id'], $options);

    if (isset($request['format']) && $request['format'] == 'mini')
    {
      $this->setTemplate('searchMini');
    }
  }

  public function executeJoin(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'event id is not specified');
    $eventId = $request['id'];

    $eventMember = Doctrine::getTable('CommunityEventMember')
      ->retrieveByEventIdAndMemberId($eventId, $this->getUser()->getMemberId());

    if (isset($request['leave']))
    {
      if (!$eventMember)
      {
        $this->forward400('You can\'t leave this event.');
      }
      $eventMember->delete();
      $this->events = null;
    }
    else
    {
      if ($eventMember)
      {
        $this->forward400('You are already this event member.');
      }

      $event = new CommunityEventMember();
      $event->setCommunityEventId($eventId);
      $event->setMemberId($this->getUser()->getMemberId());

      $event->save();

      $events = Doctrine::getTable('CommunityEvent')->createQuery('q')
        ->where('id = ?', $eventId)
        ->execute();
      $this->events = $events;
    }
  }

  public function executeMemberList(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['id']) || '' === (string)$request['id'], 'event id is not specified');
    $eventId = $request['id'];

    $this->eventMembers = Doctrine::getTable('Member')->createQuery('m')
      ->addWhere('EXISTS (FROM CommunityEventMember cem WHERE m.id = cem.member_id AND cem.community_event_id = ?)', $eventId)
      ->limit(200)
      ->execute();
  }
}
