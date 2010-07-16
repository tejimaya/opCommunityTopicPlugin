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
    $this->setDefault('update_activity', Doctrine::getTable('SnsConfig')->get('op_community_topic_update_activity', '0'));
    $this->widgetSchema->setHelp('update_activity', 'If this is used, activity message is updated automatically by posting a topic. To show the activity list, see "Appearance" > "ガジェット設定".');

    if (version_compare(OPENPNE_VERSION, '3.6beta1-dev', '<'))
    {
      unset($this['update_activity']);
    }

    $this->widgetSchema->setNameFormat('op_community_topic_plugin[%s]');
  }

  public function save()
  {
    $names = array('update_activity');

    foreach ($names as $name)
    {
      Doctrine::getTable('SnsConfig')->set('op_community_topic_plugin_'.$name, $this->getValue($name));
    }
  }
}
