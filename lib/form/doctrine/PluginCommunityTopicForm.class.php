<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopic form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
abstract class PluginCommunityTopicForm extends BaseCommunityTopicForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['community_id']);
    unset($this['member_id']);
    unset($this['created_at']);
    unset($this['updated_at']);
    unset($this['topic_updated_at']);

    $is_mobile = !opMobileUserAgent::getInstance()->getMobile()->isNonMobile();
    
    if (!$is_mobile && sfConfig::get('app_community_topic_is_upload_images', true))
    {
      $images = array();
      if (!$this->isNew())
      {
        $images = $this->getObject()->getCommunityTopicImagesJoinFile();
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
          $image = new CommunityTopicImage();
          $image->setCommunityTopic($this->getObject());
          $image->setNumber($i);  
        }
        $imageForm = new CommunityTopicImageForm($image);
        $imageForm->getWidgetSchema()->setFormFormatterName('list');
        $this->embedForm($key, $imageForm, '<ul id="community_topic_'.$key.'">%content%</ul>');
      }
    }
    $this->setWidget('name', new sfWidgetFormInput());
    $this->widgetSchema->getFormFormatter()->setTranslationCatalogue('community_topic_form');
  }

  public function updateObject($values = null)
  {
    $object = parent::updateObject($values);

    foreach ($this->embeddedForms as $key => $form)
    {
      if (!($form->getObject() && $form->getObject()->File != null))
      {
        unset($this->embeddedForms[$key]);
      }
    }

    return $object;
  }
}
