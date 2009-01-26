<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityTopic form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class CommunityTopicForm extends BaseCommunityTopicForm
{
  public function configure()
  {
    unset($this['id']);
    unset($this['community_id']);
    unset($this['member_id']);
    unset($this['created_at']);
    unset($this['updated_at']);

    $this->setWidget('name', new sfWidgetFormInput());
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('community_topic_form');
  }
}
