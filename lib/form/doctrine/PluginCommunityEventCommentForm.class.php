<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEventComment form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
abstract class PluginCommunityEventCommentForm extends BaseCommunityEventCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['community_event_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
    unset($this['updated_at']);

    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Comment'));
    $this->setValidator('body', new opValidatorString(array('rtrim' => true)));
  }

  public function save($con = null)
  {
    $communityEventComment = parent::save($con);
    $communityEvent = $communityEventComment->getCommunityEvent();
    $communityEvent->setUpdatedAt($communityEventComment->getCreatedAt());
    $communityEvent->save();
  }
}
