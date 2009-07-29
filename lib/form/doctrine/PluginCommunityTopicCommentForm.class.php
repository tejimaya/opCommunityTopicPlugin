<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopicComment form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
abstract class PluginCommunityTopicCommentForm extends BaseCommunityTopicCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['community_topic_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
    unset($this['updated_at']);

    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Comment'));
    $this->setValidator('body', new opValidatorString(array('rtrim' => true)));
  }

  public function save($con = null)
  {
    $communityTopicComment = parent::save($con);
    $communityTopic = $communityTopicComment->getCommunityTopic();
    $communityTopic->setUpdatedAt($communityTopicComment->getCreatedAt());
    $communityTopic->save();
  }
}
