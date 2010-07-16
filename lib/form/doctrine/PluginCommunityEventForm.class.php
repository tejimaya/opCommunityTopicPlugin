<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEvent form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class PluginCommunityEventForm extends BaseCommunityEventForm
{
  public function setup()
  {
    parent::setup();

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

    $this->setValidator('name', new opValidatorString(array('rtrim' => true)));
    $this->setValidator('body', new opValidatorString(array('rtrim' => true)));
    $this->setValidator('area', new opValidatorString(array('rtrim' => true)));

    $this->setValidator('open_date_comment', new sfValidatorString(array('required' => false)));
    $this->setValidator('application_deadline', new sfValidatorDate(array(
      'required' => false,
      'min' => strtotime(date('Y-m-d'))
    ), array('min' => sfContext::getInstance()->getI18N()->__('The date must be after now.'))));

    $validatorOpenDate = new sfValidatorCallback(array('callback' => array($this, 'validateOpenDate')));
    $this->mergePostValidator($validatorOpenDate);

    $validatorApplicationDeadline = new sfValidatorCallback(array('callback' => array($this, 'validateApplicationDeadline')));
    $validatorApplicationDeadline->addMessage('invalid_application_deadline', sfContext::getInstance()->getI18N()->__('The application deadline must be before the open date.'));
    $this->mergePostValidator($validatorApplicationDeadline);

    if (opMobileUserAgent::getInstance()->getMobile()->isNonMobile())
    {
      $images = array();
      if (!$this->isNew())
      {
        $images = $this->getObject()->getImages();
      }

      $max = (int)sfConfig::get('app_community_topic_max_image_file_num', 3);
      for ($i = 0; $i < $max; $i++)
      {
        $key = 'photo_'.($i+1);

        if (isset($images[$i]))
        {
          $image = $images[$i];
        }
        else
        {
          $image = new CommunityEventImage();
          $image->setCommunityEvent($this->getObject());
          $image->setNumber($i + 1);
        }
        $imageForm = new opCommunityTopicPluginImageForm($image);
        $imageForm->getWidgetSchema()->setFormFormatterName('list');
        $this->embedForm($key, $imageForm, '<ul id="community_event_'.$key.'">%content%</ul>');
      }
    }

    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('community_event_form');
  }

  public function updateObject($values = null)
  {
    if (null === $values)
    {
      $values = $this->values;
    }

    $object = parent::updateObject($values);

    foreach ($this->embeddedForms as $key => $form)
    {
      if (!($form->getObject() && $form->getObject()->File != null)
        || (isset($values[$key]) && empty($values[$key]['photo']) && empty($values[$key]['photo_delete']))
      )
      {
        unset($this->embeddedForms[$key]);
      }
    }

    return $object;
  }

  public function validateOpenDate($validator, $value)
  {
    if ($this->isNew())
    {
      $dateValidator = new sfValidatorDate(array('min' => strtotime(date('Y-m-d'))), array('min' => sfContext::getInstance()->getI18N()->__('The open date must be after now.')));
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
        throw new sfValidatorError($validator, 'invalid_application_deadline');
      }
    }

    return $value;
  }

  public function save($con = null)
  {
    $result = parent::save($con);

    if ($this->isNew())
    {
      opCommunityTopicToolkit::sendNotificationMail($result->getCommunity(), $result->getId(), 'event', $result->getMember()->getName(), $result->getName(), $result->getBody());
    }

    return $result;
  }
}
