<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class communityTopicComponents extends sfComponents
{
  public function executeCommunityTopicList()
  {
    $publicFlag = CommunityConfigPeer::retrieveByNameAndCommunityId('public_flag', $this->community->getId());
    $isBelong = $this->community->isPrivilegeBelong($this->getUser()->getMemberId());
    $this->hasPermission = true;

    if ($publicFlag && !$isBelong && $publicFlag->getValue() !== 'public')
    {
      $this->hasPermission = true;
      return sfView::SUCCESS;
    }

    $this->communityTopics = CommunityTopicPeer::getTopics($this->community->getId());
  }

  public function executeTopicCommentListBox()
  {
    $this->communityTopic = CommunityTopicPeer::retrivesByMemberId($this->getUser()->getMember()->getId(), $this->gadget->getConfig('col'));
  }
}
