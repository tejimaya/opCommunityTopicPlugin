<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopicSearch form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
class PluginCommunityTopicSearchForm extends sfForm
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    return parent::__construct($defaults, $options, false);
  }

  public function configure()
  {
    $i18n = sfContext::getInstance()->getI18N();
    $types = array(
      'topic' => $i18n->__('Topic'),
      'event' => $i18n->__('Event'),
    );
    $targets = array(
      'in_community' => $i18n->__('In Community', array(), 'form_community'),
      'all' => $i18n->__('All Community', array(), 'form_community'),
    );

    $widgets = array(
      'keyword' => new sfWidgetFormInput(array(
        'label' => $i18n->__('Keyword', array(), 'form_community'),
      )),
      'target' => new sfWidgetFormChoice(array(
        'choices' => $targets,
        'label' => $i18n->__('Target', array(), 'form_community'),
      )),
      'type' => new sfWidgetFormChoice(array(
        'choices' => $types,
        'label' => $i18n->__('Type', array(), 'form_community'),
      )),
      'id' => new sfWidgetFormInputHidden(),
    );

    $validators = array(
      'keyword' => new opValidatorSearchQueryString(array('required' => false)),
      'target' => new sfValidatorChoice(array('choices' => array_keys($targets), 'required' => false)),
      'type' => new sfValidatorChoice(array('choices' => array_keys($types), 'required' => false)),
      'id' => new sfValidatorNumber(array('required' => false)),
    );

    $this->setWidgets($widgets);
    $this->setValidators($validators);
  }
}
