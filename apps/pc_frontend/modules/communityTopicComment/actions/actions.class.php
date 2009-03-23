<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityTopicComment actions.
 *
 * @package    OpenPNE
 * @subpackage communityTopicComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class communityTopicCommentActions extends opCommunityTopicPluginTopicCommentActions
{
  /**
   * postExecute
   */
  public function postExecute()
  {
    sfConfig::set('sf_nav_type', 'community');
    sfConfig::set('sf_nav_id', $this->community->getId());
  }
}
