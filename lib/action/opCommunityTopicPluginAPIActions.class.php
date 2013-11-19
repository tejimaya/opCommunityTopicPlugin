<?php
class opCommunityTopicPluginAPIActions extends opJsonApiActions
{
  protected function getTargetObject($target, $targetId)
  {
    switch ($target)
    {
      case 'community':
        $table = 'Community';
        break;
      case 'member':
        $table = 'Member';
        break;
      case 'event':
        $table = 'CommunityEvent';
        break;
      case 'topic':
        $table = 'CommunityTopic';
        break;
      default:
        throw new opCommunityTopicAPIRuntimeException('invalid target');
    }

    if (!$targetId)
    {
      throw new opCommunityTopicAPIRuntimeException('target_id is not specified');
    }

    if (!$object = Doctrine::getTable($table)->findOneById($targetId))
    {
      throw new opCommunityTopicAPIRuntimeException($target.' does not exist');
    }

    return $object;
  }

  protected function getOptions($request)
  {
    return array(
      'limit' => isset($request['count']) ? $request['count'] : sfConfig::get('app_json_api_limit', 15),
      'max_id' => $request['max_id'] ? $request['max_id'] : null,
      'since_id' => $request['since_id'] ? $request['since_id'] : null,
      'page' => $request->getParameter('page', 1),
    );
  }

  protected function getViewableEvent($id, Member $member)
  {
    try
    {
      $event = $this->getTargetObject('event', $id);
      if (!$this->isAllowed($event, $member, 'view'))
      {
        throw new opCommunityTopicAPIRuntimeException('you are not allowed to view event on this community');
      }
    }
    catch (opCommunityTopicAPIRuntimeException $e)
    {
      $this->forward400($e->getMessage());
    }

    return $event;
  }

  protected function getViewableTopic($id, Member $member)
  {
    try
    {
      $topic = $this->getTargetObject('topic', $id);
      if (!$this->isAllowed($topic, $member, 'view'))
      {
        throw new opCommunityTopicAPIRuntimeException('you are not allowed to view event on this community');
      }
    }
    catch (opCommunityTopicAPIRuntimeException $e)
    {
      $this->forward400($e->getMessage());
    }

    return $topic;
  }

  protected function isValidNameAndBody($name, $body)
  {
    try
    {
      $validator = new opValidatorString(array('trim' => true, 'required' => true));
      $cleanName = $validator->clean($name);
      $cleanBody = $validator->clean($body);
    }
    catch (sfValidatorError $e)
    {
      $this->forward400Unless(isset($cleanName), 'name parameter is not specified.');
      $this->forward400Unless(isset($cleanBody), 'body parameter is not specified.');
    }
  }

  protected function getEventsPager($target, $targetId, $options)
  {
    if ('community' == $target)
    {
      $query = Doctrine::getTable('CommunityEvent')->createQuery()
        ->where('community_id = ?', $targetId)
        ->orderBy('event_updated_at DESC');
      $pager = $this->getPager('CommunityEvent', $query, $options);
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
      $query = Doctrine::getTable('CommunityTopic')->createQuery()
        ->where('community_id = ?', $targetId)
        ->orderBy('topic_updated_at DESC');

      $pager = $this->getPager('CommunityTopic', $query, $options);
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

    if ($options['max_id'] && $options['since_id'] && $options['max_id'] < $options['since_id'])
    {
      throw new opCommunityTopicAPIRuntimeException('please set since_id to max_id or less');
    }
    if($options['max_id'])
    {
      $query->addWhere('id <= ?', $options['max_id']);
    }

    if($options['since_id'])
    {
      $query->addWhere('id >= ?', $options['since_id']);
    }

    $pager = new sfDoctrinePager($tableName, $limit);
    $pager->setQuery($query);
    $pager->setPage($options['page']);
    $pager->init();

    return $pager;
  }

  protected function isAllowed(opDoctrineRecord $object, Member $member, $action)
  {
    if ($object instanceof Community)
    {
      $acl = opCommunityTopicAclBuilder::buildCollection($object, array($this->member));
    }
    elseif ($object instanceof CommunityTopic || $object instanceof CommunityEvent)
    {
      $acl = opCommunityTopicAclBuilder::buildResource($object, array($this->member));
    }

    return $acl->isAllowed($this->member->getId(), null, $action);
  }
}
