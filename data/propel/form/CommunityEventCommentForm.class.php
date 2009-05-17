<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityEventComment form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class CommunityEventCommentForm extends BaseCommunityEventCommentForm
{
  public function configure()
  {
    unset($this['id']);
    unset($this['community_event_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
  }

  public function save($con = null)
  {
    $communityEventComment = parent::save($con);
    $communityEvent = $communityEventComment->getCommunityEvent();
    $communityEvent->setUpdatedAt($communityEventComment->getCreatedAt());
    $communityEvent->save();
  }
}
