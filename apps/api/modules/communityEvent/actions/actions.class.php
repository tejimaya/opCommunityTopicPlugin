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
class communityEventActions extends opJsonApiActions
{
  public function preExecute()
  {
    parent::preExecute();
    $this->member = $this->getUser()->getMember();
  }

  public function executeSearch(sfWebRequest $request)
  {
    $this->forward400If(!isset($request['target']) || '' === (string)$request['target'], 'target is not specified');
    $limit = isset($request['count']) ? $request['count'] : sfConfig::get('op_json_api_limit', 15);

    if ($request['target'] == 'community')
    {
      $this->forward400If(!isset($request['target_id']) || '' === (string)$request['target_id'], 'community id is not specified');

      $query = Doctrine::getTable('CommunityEvent')->createQuery('t')
        ->where('community_id = ?', $request['target_id'])
        ->orderBy('event_updated_at desc')
        ->limit($limit);

      if(isset($request['max_id']))
      {
        $query->addWhere('id <= ?', $request['max_id']);
      }

      if(isset($request['since_id']))
      {
        $query->addWhere('id > ?', $request['since_id']);
      }

      $this->events = $query->execute();
    }
    elseif($request['target'] == 'event')
    {
      $this->forward400If(!isset($request['target_id']) || '' === (string)$request['target_id'], 'event id is not specified');

      $event = Doctrine::getTable('CommunityEvent')->findOneById($request['target_id']);

      $this->memberId = $this->getUser()->getMemberId();
      $this->events = array($event);
    }
    elseif ($request['target'] == 'member')
    {
      $this->forward400If(!isset($request['target_id']) || '' === (string)$request['target_id'], 'member id is not specified');
      $memberId = $request['target_id'];

      $events = Doctrine::getTable('CommunityEventMember')->createQuery('q')
        ->select('community_event_id')
        ->where('member_id = ?', $memberId)
        ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
        ->execute();
      
      $eventIds = array();
      foreach($events as $_event)
      {
        array_push($eventIds, $_event['community_event_id']);
      }
    
      $events = Doctrine::getTable('CommunityEvent')->createQuery('q')
        ->whereIn('id', $eventIds)
        ->orderBy('event_updated_at desc')
        ->limit($limit)
        ->execute();

      $this->events = $events;
      $this->memberId = $memberId;
    }

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
