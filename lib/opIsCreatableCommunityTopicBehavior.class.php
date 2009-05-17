<?php

class opIsCreatableCommunityTopicBehavior extends Doctrine_Template
{
  public function isCreatableCommunityTopic($community, $memberId)
  {
    if ($community->getConfig('topic_authority') === 'admin_only')
    {
      return $community->isAdmin($memberId);
    }

    return $community->isPrivilegeBelong($memberId);
  }

  public function isViewableCommunityTopic($community, $memberId)
  {
    if ($community->getConfig('public_flag') === 'auth_commu_member')
    {
      return $community->isPrivilegeBelong($memberId);
    }

    // all of the SNS members are viewable this topic comment
    return true;
  }
}
