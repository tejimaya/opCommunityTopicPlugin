<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityTopicComment form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class CommunityTopicCommentForm extends BaseCommunityTopicCommentForm
{
  public function configure()
  {
    unset($this['id']);
    unset($this['community_topic_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
  }

  public function save($con = null)
  {
    $communityTopicComment = parent::save($con);
    $communityTopic = $communityTopicComment->getCommunityTopic();
    $communityTopic->setUpdatedAt($communityTopicComment->getCreatedAt());
    $communityTopic->save();
  }
}
