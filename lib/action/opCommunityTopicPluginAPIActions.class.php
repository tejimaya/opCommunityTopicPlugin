<?php
class opCommunityTopicPluginAPIActions extends opJsonApiActions
{
  protected function getValidTarget($request)
  {
    if (!isset($request['target']))
    {
      throw new Exception('target is not specified');
    }

    if (!isset($request['target_id']) || '' == $request['target_id'])
    {
      throw new Exception($request['target'].' is not specified');
    }

    switch ($request['target'])
    {
      case 'community':
      case 'member':
      case 'event':
      case 'topic':
        return $request['target'];
        break;
      default:
        throw new Exception('invalid target');
    }
  }

  protected function getOptions($request)
  {
    $limit = isset($request['count']) ? $request['count'] : sfConfig::get('op_json_api_limit', 15);

    return array(
      'limit' => $limit,
      'max_id' => $request['max_id'] ? $request['max_id'] : null,
      'since_id' => $request['since_id'] ? $request['since_id'] : null,
    );
  }

  protected function getEventByEventId($id)
  {
    if (!$event = Doctrine::getTable('CommunityEvent')->findOneById($id))
    {
      $this->forward400('the specified Event does not exist.');
    }

    return $event;
  }

  protected function getTopicByTopicId($id)
  {
    if (!$topic = Doctrine::getTable('CommunityTopic')->findOneById($id))
    {
      $this->forward400('the specified topic does not exist.');
    };

    return $topic;
  }

  protected function isValidNameAndBody($request)
  {
    try
    {
      $validator = new opValidatorString(array('trim' => true));
      $cleanName = $validator->clean($request['name']);
      $cleanBody = $validator->clean($request['body']);
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
      ->orderBy('event_updated_at desc')
      ->limit($options['limit']);

    if($options['max_id'])
    {
      $query->addWhere('id <= ?', $options['max_id']);
    }

    if($options['since_id'])
    {
      $query->addWhere('id > ?', $options['since_id']);
    }

    return $query->execute();
  }

  protected function searchTopicByCommunityId($targetId, $options)
  {
    $query = Doctrine::getTable('CommunityTopic')->createQuery('t')
      ->where('community_id = ?', $targetId)
      ->orderBy('topic_updated_at desc')
      ->limit($options['limit']);

    if($options['max_id'])
    {
      $query->addWhere('id <= ?', $options['max_id']);
    }

    if($options['since_id'])
    {
      $query->addWhere('id > ?', $options['since_id']);
    }

    return $query->execute();
  }

  protected function getEvents($target, $targetId, $options)
  {
    $events = array();

    if ('community' == $target)
    {
      $events = $this->searchEventsByCommunityId($targetId, $options);
    }
    elseif ('member' == $target)
    {
      if (!$member = Doctrine::getTable('Member')->findOneById($targetId))
      {
        $this->forward400('target_id is invalid');
      }

      $events = Doctrine::getTable('CommunityEvent')->retrivesByMemberId($member->getId(), $options['limit']);
    }
    elseif ('event' == $target)
    {
      $event = $this->getEventByEventId($targetId);
      $event->actAs('opIsCreatableCommunityTopicBehavior');
      if(!$event->isViewableCommunityTopic($event->getCommunity(), $this->member->getId()))
      {
        $this->forward400('you are not allowed to view event on this community');
      }
      $events = array($event);
    }

    return $events;
  }

  protected function getTopics($target, $targetId, $options)
  {
    $topic = array();

    if ('community' == $target)
    {
      $topics = $this->searchTopicByCommunityId($targetId, $options);
    }
    elseif('topic' == $target)
    {
      $topic = $this->getTopicByTopicId($targetId);

      $topic->actAs('opIsCreatableCommunityTopicBehavior');
      $this->forward400If(!$topic->isViewableCommunityTopic($topic->getCommunity(), $this->member->getId()), 'you are not allowed to view topics on this community');
      $topics = array($topic);
    }
    elseif ('member' == $target)
    {
      if (!$member = Doctrine::getTable('Member')->findOneById($targetId))
      {
        $this->forward400('target_id is invalid');
      }
      $topics = Doctrine::getTable('CommunityTopic')->retrivesByMemberId($member->getId(), $options['limit']);
    }

    return $topics;
  }
}
