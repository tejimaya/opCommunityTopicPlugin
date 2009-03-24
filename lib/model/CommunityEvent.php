<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class CommunityEvent extends BaseCommunityEvent
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
    return (bool)CommunityEventMemberPeer::retrieveByEventIdAndMemberId($this->getId(), $memberId);
  }

  public function isEventModified()
  {
    return (
      $this->isColumnModified(CommunityEventPeer::NAME) ||
      $this->isColumnModified(CommunityEventPeer::BODY)
    );
  }

  public function save(PropelPDO $con = null)
  {
    if ($this->isEventModified() && !$this->isColumnModified(CommunityEventPeer::EVENT_UPDATED_AT))
    {
      $this->setEventUpdatedAt(time());
    }
    
    parent::save($con);
  }

  public function toggleEventMember($memberId)
  {
    if ($this->isEventMember($memberId))
    {
      $eventMember = CommunityEventMemberPeer::retrieveByEventIdAndMemberId($this->getId(), $memberId);
      $eventMember->delete();
    }
    else
    {
      $eventMember = new CommunityEventMember();
      $eventMember->setCommunityEventId($this->getId());
      $eventMember->setMemberId($memberId);

      $this->addCommunityEventMember($eventMember);
    }
  }
}
