<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityTopicComment scomponents.
 *
 * @package    OpenPNE
 * @subpackage communityTopicComment
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class communityTopicCommentComponents extends sfComponents
{
  public function executeList(sfWebRequest $request)
  {
    $this->commentPager = CommunityTopicCommentPeer::getCommunityTopicCommentListPager($this->communityTopic->getId(), $request->getParameter('page'), 20);
  }
}
