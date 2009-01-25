<?php

class opIsCreatableCommunityTopicBehavior
{
  public function isCreatableCommunityTopic($community, $memberId)
  {
    if ($community->getConfig('topic_authority') === 'admin_only')
    {
      return $community->isAdmin($memberId);
    }

    return $community->isPrivilegeBelong($memberId);
  }
}
