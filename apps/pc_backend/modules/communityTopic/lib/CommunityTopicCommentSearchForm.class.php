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
  public function configure()
  {
    $q = Doctrine::getTable('CommunityTopicComment')->createQuery()->where('id > 0');
    $this->setWidgets(array(
      'number'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'body'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'number' => new sfValidatorPass(),
      'body' => new sfValidatorPass(),
    ));

    $this->widgetSchema->setLabel('number', sfContext::getInstance()->getI18N()->__('Comment Number'));
    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Topic Comment Description'));

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    $this->widgetSchema->setNameFormat('communityTopicComment[%s]');
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('form_community');
  }
}
