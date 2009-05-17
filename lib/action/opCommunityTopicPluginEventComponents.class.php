<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginEventComponents
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class opCommunityTopicPluginEventComponents extends sfComponents
{
  public function executeCommunityEventList()
  {
    $publicFlag = Doctrine::getTable('CommunityConfig')->retrieveByNameAndCommunityId('public_flag', $this->community->getId());
    $isBelong = $this->community->isPrivilegeBelong($this->getUser()->getMemberId());
    $this->hasPermission = true;

    if ($publicFlag && !$isBelong && $publicFlag->getValue() !== 'public')
    {
      $this->hasPermission = true;
      return sfView::SUCCESS;
    }

    $this->communityEvents = Doctrine::getTable('CommunityEvent')->getEvents($this->community->getId());
  }

  public function executeEventCommentListBox()
  {
    $this->communityEvent = Doctrine::getTable('CommunityEvent')->retrivesByMemberId($this->getUser()->getMember()->getId(), $this->gadget->getConfig('col'));
  }
}
