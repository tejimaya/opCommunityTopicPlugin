<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEvent
 * 
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityEvent
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
abstract class PluginCommunityEvent extends BaseCommunityEvent
{
  public function isEditable($memberId)
  {
    if (!$this->getCommunity()->isPrivilegeBelong($memberId))
    {
      return false;
    }

    return ($this->getMemberId() === $memberId || $this->getCommunity()->isAdmin($memberId));
  }

  public function isCreatableCommunityEventComment($memberId)
  {
    return $this->getCommunity()->isPrivilegeBelong($memberId);
  }

  public function isEventMember($memberId)
  {
    return (bool)Doctrine::getTable('CommunityEventMember')->retrieveByEventIdAndMemberId($this->getId(), $memberId);
  }

  public function isEventModified()
  {
    $modified = $this->getModified();
    return (isset($modified['name']) || isset($modified['body']));
  }

  public function preSave($event)
  {
    $modified = $this->getModified();
    if ($this->isEventModified() && empty($modified['event_updated_at']))
    {
      $this->setEventUpdatedAt(date('Y-m-d H:i:s', time()));
    }
  }

  public function toggleEventMember($memberId)
  {
    if ($this->isClosed())
    {
      throw new opCommunityEventMemberAppendableException('This event has already been finished.');
    }

    if ($this->isExpired())
    {
      throw new opCommunityEventMemberAppendableException('This event has already been expired.');
    }

    if ($this->isEventMember($memberId))
    {
      $eventMember = Doctrine::getTable('CommunityEventMember')->retrieveByEventIdAndMemberId($this->getId(), $memberId);
      $eventMember->delete();
    }
    else
    {
      if ($this->isAtCapacity())
      {
        throw new opCommunityEventMemberAppendableException('This event has already been at capacity.');
      }

      $eventMember = new CommunityEventMember();
      $eventMember->setCommunityEventId($this->getId());
      $eventMember->setMemberId($memberId);
      $eventMember->save();
    }
  }

  public function isClosed()
  {
    return (time() > strtotime($this->getOpenDate().'+1day'));
  }

  public function isExpired()
  {
    return (!is_null($this->getApplicationDeadline()) && time() > strtotime($this->getApplicationDeadline().'+1day'));
  }

  public function isAtCapacity()
  {
    return (!is_null($this->getCapacity()) && $this->countCommunityEventMembers() >= $this->getCapacity());
  }

  public function countCommunityEventMembers()
  {
    return Doctrine_Query::create()
      ->select('count(*) as count')
      ->from('CommunityEventMember m')
      ->where('m.community_event_id = ?', $this->getId())
      ->fetchOne()
      ->getCount();
  }

  // for pager
  public function getImageFilename()
  {
    $this->getCommunity()->getImageFilename();
  }

  public function postInsert($event)
  {
    if (Doctrine::getTable('SnsConfig')->get('op_community_topic_plugin_update_activity', false)
      && defined('OPENPNE_VERSION') && version_compare(OPENPNE_VERSION, '3.6beta1-dev', '>='))
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('Helper', 'opUtil'));

      $open = op_format_date($this->getOpenDate(), 'D').($this->getOpenDate() ? ' '.$this->getOpenDateComment() : '');
      $body = '[%Community% Event] ('.$this->getCommunity()->getName().' %community%) '.$this->name.' (open '.$open.')';
      $options = array(
        'public_flag' => $this->getCommunity()->getConfig('public_flag') === 'public' ? 1 : 3,
        'uri' => '@communityEvent_show?id='.$this->id,
        'source' => 'CommunityEvent',
        'template' => 'community_event',
        'template_param' => array('%1%' => $this->getCommunity()->getName(), '%2%' => $this->name, '%3%' => $open),
      );
      Doctrine::getTable('ActivityData')->updateActivity($this->member_id, $body, $options);
    }
  }
}
