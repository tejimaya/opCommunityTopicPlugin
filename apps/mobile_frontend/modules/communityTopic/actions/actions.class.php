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
 * @author     Shogo Kawahara <kawahara@tejimaya.net>
 */
class communityTopicActions extends opCommunityTopicPluginTopicActions
{
  /**
   * Executes list community.
   *
   * @param sfWebRequest $request
   */
  public function executeListCommunity(sfWebRequest $request)
  {
    $this->size = 10;

    return parent::executeListCommunity($request);
  }

  /**
   * Executes recently topic list.
   *
   * @param sfWebRequest $request
   */
  public function executeRecentlyTopicList(sfWebRequest $request)
  {
    $this->size = 10;

    return parent::executeRecentlyTopicList($request);
  }
}
