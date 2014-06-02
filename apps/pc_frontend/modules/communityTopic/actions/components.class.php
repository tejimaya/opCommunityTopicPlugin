<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class communityTopicComponents extends opCommunityTopicPluginTopicComponents
{
  public function executeTopicCommentSnsListBox()
  {
    $this->communityTopic = Doctrine_Core::getTable('CommunityTopic')
      ->getRecentlyUpdatedTopicsSns($this->gadget->getConfig('col'));
  }
}
