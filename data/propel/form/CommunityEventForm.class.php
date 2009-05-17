<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityEvent form.
 *
 * @package    OpenPNE
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class CommunityEventForm extends BaseCommunityEventForm
{
  public function configure()
  {
    unset($this['id']);
    unset($this['community_id']);
    unset($this['member_id']);
    unset($this['created_at']);
    unset($this['updated_at']);
    unset($this['event_updated_at']);

    $dateParam = array(
      'culture'      => sfContext::getInstance()->getUser()->getCulture(),
      'month_format' => 'number',
    );

    $this->setWidget('name', new sfWidgetFormInput());
    $this->setWidget('open_date', new opWidgetFormDate($dateParam));
    $this->setWidget('application_deadline', new opWidgetFormDate(array_merge($dateParam, array('can_be_empty' => true))));
    $this->setWidget('open_date_comment', new sfWidgetFormInput());
    $this->setWidget('area', new sfWidgetFormInput());

    $this->setValidator('application_deadline', new sfValidatorDate(array(
      'required' => false,
      'min' => strtotime(date('Y-m-d'))
    ), array('min' => 'The date must be after now.')));

    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateOpenDate'))));
    $this->mergePostValidator(new sfValidatorCallback(array('callback' => array($this, 'validateApplicationDeadline'))));

    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('community_event_form');
  }

  public function validateOpenDate($validator, $value)
  {
    if ($this->isNew())
    {
      $dateValidator = new sfValidatorDate(array('min' => strtotime(date('Y-m-d'))), array('min' => 'The date must be after now.'));
      $value['open_date'] = $dateValidator->clean($value['open_date']);
    }

    return $value;
  }

  public function validateApplicationDeadline($validator, $value)
  {
    if ($value['application_deadline'])
    {
      if (strtotime($value['application_deadline']) > strtotime($value['open_date']))
      {
        throw new sfValidatorError($validator, 'invalid');
      }
    }

    return $value;
  }

}
