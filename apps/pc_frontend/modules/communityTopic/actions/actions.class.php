<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityTopic actions.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class communityTopicActions extends opCommunityTopicPluginTopicActions
{
  /**
   * postExecute
   */
  public function postExecute()
  {
    if ($this->community instanceof Community)
    {
      sfConfig::set('sf_nav_type', 'community');
      sfConfig::set('sf_nav_id', $this->community->getId());
    }
  }
}
