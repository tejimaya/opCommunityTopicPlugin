<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opConfigCommunityTopicNotificationMailForm
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opConfigCommunityTopicNotificationMailForm extends BaseForm
{
  protected
    $id, $communityMember;

  protected $choices = array(
    1 => 'Want to receive',
    0 => 'Don\'t want to receive',
  );

  public function __construct($id, $options = array(), $CSRFSecret = null)
  {
    $this->id = $id;
    $this->communityMember = Doctrine::getTable('CommunityMember')
      ->retrieveByMemberIdAndCommunityId(sfContext::getInstance()->getUser()->getMemberId(), $id);
    if (!$this->communityMember)
    {
      throw new RuntimeException();
    }

    parent::__construct(array(), $options, $CSRFSecret);
  }

  public function configure()
  {
    $this->setWidget('to_pc_address', new sfWidgetFormSelectRadio(array(
      'choices' => $this->choices,
      'default' => $this->communityMember->getIsReceiveMailPc(),
      'label'   => 'Configuration of %community% topic notification mail to your PC mail address',
    )));
    $this->setValidator('to_pc_address', new sfValidatorChoice(array(
      'choices' => array_keys($this->choices),
      'required' => false,
    )));

    $this->setWidget('to_mobile_address', new sfWidgetFormSelectRadio(array(
      'choices' => $this->choices,
      'default' => $this->communityMember->getIsReceiveMailMobile(),
      'label'   => 'Configuration of %community% topic notification mail to your mobile mail address',
    )));
    $this->setValidator('to_mobile_address', new sfValidatorChoice(array(
      'choices'  => array_keys($this->choices),
      'required' => false,
    )));

    $this->widgetSchema->setNameFormat('topic_notify[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('messages');
  }

  public function save()
  {
    if (null !== $this->getValue('to_pc_address'))
    {
      $this->communityMember->setIsReceiveMailPc((bool)$this->getValue('to_pc_address'));
    }

    if (null !== $this->getValue('to_mobile_address'))
    {
      $this->communityMember->setIsReceiveMailMobile((bool)$this->getValue('to_mobile_address'));
    }

    $this->communityMember->save();
  }
}
