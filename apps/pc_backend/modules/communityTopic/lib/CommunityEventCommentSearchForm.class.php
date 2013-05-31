<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * Community Event Comment Search Form
 *
 * @package    OpenPNE
 * @subpackage filter
 * @author     Yoichiro SAKURAI <saku2saku@gmail.com>
 */

class CommunityEventCommentSearchForm extends PluginCommunityEventCommentFormFilter
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    return parent::__construct($defaults, $options, false);
  }

  public function configure()
  {
    if (!isset($this->option['query']))
    {
      $query = $this->getTable()->createQuery('c')->leftJoin('c.Member m');
      $this->setQuery($query);
    }

    $this->setWidgets(array(
      'community_event_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'number'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'member_name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'body'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'community_event_id' => new sfValidatorPass(),
      'number' => new sfValidatorPass(),
      'member_name' => new sfValidatorPass(),
      'body' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setLabel('community_event_id', sfContext::getInstance()->getI18N()->__('Event ID'));
    $this->widgetSchema->setLabel('number', sfContext::getInstance()->getI18N()->__('Comment Number'));
    $this->widgetSchema->setLabel('member_name', sfContext::getInstance()->getI18N()->__('Nickname'));
    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Event Comment Description'));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('communityEventComment[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form_community');
  }

  protected function addCommunityEventIdColumnQuery(Doctrine_Query $query, $field, $value)
  {
    $this->_addColumnQuery($query, 'c.community_event_id', $value);
  }

  protected function addMemberNameColumnQuery(Doctrine_Query $query, $field, $value)
  {
    $this->_addColumnQuery($query, 'm.name', $value);
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
