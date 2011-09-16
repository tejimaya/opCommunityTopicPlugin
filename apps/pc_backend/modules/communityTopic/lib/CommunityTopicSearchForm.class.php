<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * Community Topic Search Form
 *
 * @package    OpenPNE
 * @subpackage filter
 * @author     Yoichiro SAKURAI <saku2saku@gmail.com>
 */

class CommunityTopicSearchForm extends PluginCommunityTopicFormFilter
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    return parent::__construct($defaults, $options, false);
  }

  public function configure()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'body'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorPass(),
      'name' => new sfValidatorPass(),
      'body' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setLabel('id', sfContext::getInstance()->getI18N()->__('Topic ID'));
    $this->widgetSchema->setLabel('name', sfContext::getInstance()->getI18N()->__('Topic Title'));
    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Topic Description'));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('communityTopic[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form_community');
  }

  protected function addNameColumnQuery(Doctrine_Query $query, $field, $value)
  {
    $this->_addColumnQuery($query, $field, $value);
  }

  protected function addBodyColumnQuery(Doctrine_Query $query, $field, $value)
  {
    $this->_addColumnQuery($query, $field, $value);
  }

  protected function _addColumnQuery(Doctrine_Query $query, $field, $value)
  {
    if (!empty($value['text']))
    {
      if (method_exists($query, 'andWhereLike'))
      {
        $query->andWhereLike($field, $value['text']);
      }
      else
      {
        $query->andWhere($field.' LIKE ?', '%'.$value['text'].'%');
      }
    }
  }
}
