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
 * @subpackage CommunityEventComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class PluginCommunityEventComment extends BaseCommunityEventComment
{
  public function isDeletable($memberId)
  {
    return ($this->getMemberId() === $memberId || $this->getCommunityEvent()->isEditable($memberId));
  }

  public function preSave($event)
  {
    $modified = $this->getModified();
    if ($this->isNew() && empty($modified['number']))
    {
      $this->getCommunityEvent()->setEventUpdatedAt(date('Y-m-d H:i:s', time()));
      $this->setNumber(Doctrine::getTable('CommunityEventComment')->getMaxNumber($this->getCommunityEventId()) + 1);
    }
  }

  public function toggleEventMember($memberId)
  {
    $this->getCommunityEvent()->toggleEventMember($memberId);
  }
}
