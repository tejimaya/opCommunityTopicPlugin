<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * Community Topic Comment Search Form
 *
 * @package    OpenPNE
 * @subpackage filter
 * @author     Yoichiro SAKURAI <saku2saku@gmail.com>
 */

class CommunityTopicCommentSearchForm extends PluginCommunityTopicCommentFormFilter
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    return parent::__construct($defaults, $options, false);
  }

  public function configure()
  {
    $this->setWidgets(array(
      'community_topic_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'number'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'member_name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'body'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'community_topic_id' => new sfValidatorPass(),
      'number' => new sfValidatorPass(),
      'member_name' => new sfValidatorPass(),
      'body' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setLabel('community_topic_id', sfContext::getInstance()->getI18N()->__('Topic ID'));
    $this->widgetSchema->setLabel('number', sfContext::getInstance()->getI18N()->__('Comment Number'));
    $this->widgetSchema->setLabel('member_name', sfContext::getInstance()->getI18N()->__('Nickname'));
    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Topic Comment Description'));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('communityTopicComment[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form_community');
  }

  public function getQuery(){
    $parameter = $this->getTaintedValues();
    $community_topic_id = $parameter['community_topic_id']['text'];
    $number = $parameter['number']['text'];
    $member_name = $parameter['member_name']['text'];
    $body = $parameter['body']['text'];
    $query = Doctrine_Query::create()->from('CommunityTopicComment c')->leftJoin('c.Member m');
    if (!empty($community_topic_id)) $query->andWhere('c.community_topic_id = ?', $community_topic_id);
    if (!empty($number)) $query->andWhere('c.number = ?', $number);
    if (!empty($member_name))
    {
      if (method_exists($query, 'andWhereLike'))
      {
        $query->andWhereLike('m.name', $member_name);
      }
      else
      {
        $query->andWhere('m.name LIKE ?', '%'.$member_name.'%');
      }
    }
    if (!empty($body))
    {
      if (method_exists($query, 'andWhereLike'))
      {
        $query->andWhereLike('c.body', $body);
      }
      else
      {
        $query->andWhere('c.body LIKE ?', '%'.$body.'%');
      }
    }

    return $query;
  }
}
