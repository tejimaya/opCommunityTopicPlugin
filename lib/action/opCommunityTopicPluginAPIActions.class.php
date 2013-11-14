<?php
class opCommunityTopicPluginAPIActions extends opJsonApiActions
{
  protected function getValidTarget($request)
  {
    switch ($request['target'])
    {
      case 'community': $table = 'Community';break;
      case 'member': $table = 'Member';break;
      case 'event': $table = 'CommunityEvent';break;
      case 'topic': $table = 'CommunityTopic';break;
      default:
        throw new Exception('invalid target');
    }

    if ($targetId = $request->getParameter('target_id'))
    {
      if (!Doctrine::getTable($table)->findOneById($targetId))
      {
        throw new Exception('requested '.$request['target'].' does not exist');
      }
    }
    else
    {
      throw new Exception($request['target'].'_id is not specified');
    }

    return $request['target'];
  }

  protected function getOptions($request)
  {
    return array(
      'limit' => isset($request['count']) ? $request['count'] : sfConfig::get('op_json_api_limit', 15),
      'max_id' => $request['max_id'] ? $request['max_id'] : null,
      'since_id' => $request['since_id'] ? $request['since_id'] : null,
      'page' => $request->getParameter('page', 1),
    );
  }

  protected function getEventByEventId($id)
  {
    if (!$event = Doctrine::getTable('CommunityEvent')->findOneById($id))
    {
      $this->forward400('the specified event does not exist.');
    }

    return $event;
  }

  protected function getTopicByTopicId($id)
  {
    if (!$topic = Doctrine::getTable('CommunityTopic')->findOneById($id))
    {
      $this->forward400('the specified topic does not exist.');
    }

    return $topic;
  }

  protected function getViewableEvent($id, $memberId)
  {
    $event = $this->getEventByEventId($id);
    if ($event)
    {
      $event->actAs('opIsCreatableCommunityTopicBehavior');
      if(!$event->isViewableCommunityTopic($event->getCommunity(), $memberId))
      {
        $this->forward400('you are not allowed to view event on this community');
      }

      return $event;
    }

    return false;
  }

  protected function getViewableTopic($id, $memberId)
  {
    $topic = getTopicByTopicId($id);
    if ($topic)
    {
      $topic->actAs('opIsCreatableCommunityTopicBehavior');
      if (!$topic->isViewableCommunityTopic($topic->getCommunity(), $memberId))
      {
        $this->forward400('you are not allowed to view this topic and comments on this community');
      }

      return $topic;
    }

    return false;
  }

  protected function isValidNameAndBody($name, $body)
  {
    if (!$name || !$body)
    {
      $this->forward400('name and body parameter required');
    }

    try
    {
      $validator = new opValidatorString(array('trim' => true));
      $cleanName = $validator->clean($name);
      $cleanBody = $validator->clean($body);
    }
    catch (sfValidatorError $e)
    {
      $this->forward400Unless(isset($cleanName), 'name parameter is not specified.');
      $this->forward400Unless(isset($cleanBody), 'body parameter is not specified.');
    }
  }

  protected function searchEventsByCommunityId($targetId, $options)
  {
    $query = Doctrine::getTable('CommunityEvent')->createQuery()
      ->where('community_id = ?', $targetId)
      ->orderBy('event_updated_at DESC');

    return $this->getPager('CommunityEvent', $query, $options);
  }

  protected function searchTopicsByCommunityId($targetId, $options)
  {
    $query = Doctrine::getTable('CommunityTopic')->createQuery('t')
      ->where('community_id = ?', $targetId)
      ->orderBy('topic_updated_at DESC');

    return $this->getPager('CommunityTopic', $query, $options);
  }

  protected function getEventsPager($target, $targetId, $options)
  {
    if ('community' == $target)
    {
      $pager = $this->searchEventsByCommunityId($targetId, $options);
    }
    elseif ('member' == $target)
    {
      $communityIds = Doctrine::getTable('Community')->getIdsByMemberId($targetId);
      $query = Doctrine::getTable('CommunityEvent')->createQuery()
        ->whereIn('community_id', $communityIds)
        ->orderBy('updated_at DESC');
      $pager = $this->getPager('CommunityEvent', $query, $options);
    }

    return $pager;
  }

  protected function getTopicsPager($target, $targetId, $options)
  {
    if ('community' == $target)
    {
      $pager = $this->searchTopicsByCommunityId($targetId, $options);
    }
    elseif ('member' == $target)
    {
      $communityIds = Doctrine::getTable('Community')->getIdsByMemberId($targetId);
      $query = Doctrine::getTable('CommunityTopic')->createQuery()
        ->whereIn('community_id', $communityIds)
        ->orderBy('updated_at DESC');
      $pager = $this->getPager('CommunityTopic', $query, $options);
    }

    return $pager;
  }

  protected function getPager($tableName, $query, $options)
  {
    $limit = ('all' === $options['page']) ? null : $options['limit'];

    if($options['max_id'])
    {
      $query->addWhere('id <= ?', $options['max_id']);
    }

    if($options['since_id'])
    {
      $query->addWhere('id > ?', $options['since_id']);
    }

    $pager = new sfDoctrinePager($tableName, $limit);
    $pager->setQuery($query);
    $pager->setPage($options['page']);
    $pager->init();

    return $pager;
  }
}
