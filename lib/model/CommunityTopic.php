<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class CommunityTopic extends BaseCommunityTopic
{
  public function isEditable($memberId)
  {
    if (!$this->getCommunity()->isPrivilegeBelong($memberId))
    {
      return false;
    }

    return ($this->getMemberId() === $memberId || $this->getCommunity()->isAdmin($memberId));
  }

  public function isViewable($memberId)
  {
    if ($this->getCommunity()->getConfig('public_flag') === 'auth_commu_member')
    {
      return $this->getCommunity()->isPrivilegeBelong($memberId);
    }

    // all of the SNS members are viewable this topic comment
    return true;
  }

  public function isCreatableComment($memberId)
  {
    return $this->getCommunity()->isPrivilegeBelong($memberId);
  }
}
