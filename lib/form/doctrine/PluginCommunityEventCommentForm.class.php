<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityEventComment form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
abstract class PluginCommunityEventCommentForm extends BaseCommunityEventCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['community_event_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
    unset($this['updated_at']);

    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Comment') . ' <strong>*</strong>');
    $this->setValidator('body', new opValidatorString(array('rtrim' => true)));

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
          $image = new CommunityEventCommentImage();
          $image->setCommunityEventComment($this->getObject());
          $image->setNumber($i + 1);
        }
        $imageForm = new opCommunityTopicPluginImageForm($image);
        $imageForm->getWidgetSchema()->setFormFormatterName('list');
        $this->embedForm($key, $imageForm, '<ul id="community_event_comment_'.$key.'">%content%</ul>');
      }
    }
  }

  public function save($con = null)
  {
    $communityEventComment = parent::save($con);
    $communityEvent = $communityEventComment->getCommunityEvent();
    $communityEvent->setUpdatedAt($communityEventComment->getCreatedAt());
    $communityEvent->save();

    if ($this->isNew())
    {
      opCommunityTopicToolkit::sendNotificationMail($communityEvent->getCommunity(), $communityEvent->getId(), 'event', $communityEventComment->getMember()->getName(), $communityEvent->getName(), $communityEventComment->getBody());
    }

    return $communityEventComment;
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
}
