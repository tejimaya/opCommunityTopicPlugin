<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * Community Event Member Search Form
 *
 * @package    OpenPNE
 * @subpackage filter
 * @author     Yoichiro SAKURAI <saku2saku@gmail.com>
 */

class CommunityEventMemberSearchForm extends PluginCommunityEventMemberFormFilter
{
  public function __construct($defaults = array(), $options = array(), $CSRFSecret = null)
  {
    return parent::__construct($defaults, $options, false);
  }

  public function configure()
  {
    $this->setWidgets(array(
      'community_event_id'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'member_name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'community_event_id' => new sfValidatorPass(),
      'member_name' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setLabel('community_event_id', sfContext::getInstance()->getI18N()->__('Event ID'));
    $this->widgetSchema->setLabel('member_name', sfContext::getInstance()->getI18N()->__('Nickname'));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('communityEventMember[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form_community');
  }

  public function getQuery(){
    $parameter = $this->getTaintedValues();
    $community_event_id = $parameter['community_event_id']['text'];
    $member_name = $parameter['member_name']['text'];
    $query = Doctrine_Query::create()->from('CommunityEventMember c')->leftJoin('c.Member m')->leftJoin('c.CommunityEvent ce');
    if (!empty($community_event_id)) $query->andWhere('c.community_event_id = ?', $community_event_id);
    if (!empty($member_name)) $query->andWhere('m.name LIKE ?', '%' . $member_name . '%');
    return $query;
  }
}
