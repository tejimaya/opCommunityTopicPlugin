<?php

class CommunityEventComment extends BaseCommunityEventComment
{
  public function isDeletable($memberId)
  {
    return ($this->getMemberId() === $memberId || $this->getCommunityEvent()->isEditable($memberId));
  }

  public function save(PropelPDO $con = null)
  {
    if ($this->isNew() && !$this->isColumnModified(CommunityEventCommentPeer::NUMBER))
    {
      $this->setNumber(CommunityEventCommentPeer::getMaxNumber($this->getCommunityEventId()) + 1);
    }

    parent::save($con);
  }

  public function toggleEventMember($memberId)
  {
    $this->getCommunityEvent()->toggleEventMember($memberId);
  }
}
