<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginConfigurationForm
 *
 * @package    OpenPNE
 * @subpackage opCommunityTopicPlugin
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicPluginConfigurationForm extends BaseForm
{
  public function configure()
  {
    $choices = array('1' => 'Use', '0' => 'Not use');

    $this->setWidget('update_activity', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('update_activity', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('update_activity', Doctrine::getTable('SnsConfig')->get('op_community_topic_plugin_update_activity', '0'));
    $this->widgetSchema->setLabel('update_activity', 'Update %activity%');
    $this->widgetSchema->setHelp('update_activity', 'If this is used, %activity% message is updated automatically by posting a topic. To show the %Activity% list, see "Appearance" > "ガジェット設定".');

    $this->setWidget('community_topic_comment_reply', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('community_topic_comment_reply', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('community_topic_comment_reply', Doctrine::getTable('SnsConfig')->get('op_community_topic_plugin_community_topic_comment_reply', '0'));
    $this->widgetSchema->setLabel('community_topic_comment_reply', '%Community% Topic comment reply');
    $this->widgetSchema->setHelp('community_topic_comment_reply', 'If this is used, you can reply to the %Community% topic comment.');

    $this->setWidget('community_event_comment_reply', new sfWidgetFormSelectRadio(array('choices' => $choices)));
    $this->setValidator('community_event_comment_reply', new sfValidatorChoice(array('choices' => array_keys($choices))));
    $this->setDefault('community_event_comment_reply', Doctrine::getTable('SnsConfig')->get('op_community_topic_plugin_community_event_comment_reply', '0'));
    $this->widgetSchema->setLabel('community_event_comment_reply', '%Community% Event comment reply');
    $this->widgetSchema->setHelp('community_event_comment_reply', 'If this is used, you can reply to the %Community% event comment.');

    if (version_compare(OPENPNE_VERSION, '3.6beta1-dev', '<'))
    {
      unset($this['update_activity']);
    }

    $this->widgetSchema->setNameFormat('op_community_topic_plugin[%s]');
  }

  public function save()
  {
    $names = array('update_activity','community_topic_comment_reply','community_event_comment_reply' );

    foreach ($names as $name)
    {
      Doctrine::getTable('SnsConfig')->set('op_community_topic_plugin_'.$name, $this->getValue($name));
    }
  }
}
