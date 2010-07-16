<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopicComment form.
 *
 * @package    opCommunityTopicPlugin
 * @subpackage form
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Eitarow Fukamachi <fukamachi@tejimaya.net>
 */
abstract class PluginCommunityTopicCommentForm extends BaseCommunityTopicCommentForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    unset($this['community_topic_id']);
    unset($this['member_id']);
    unset($this['number']);
    unset($this['created_at']);
    unset($this['updated_at']);

    if (opMobileUserAgent::getInstance()->getMobile()->isNonMobile())
    {
      $images = array();
      if (!$this->isNew())
      {
        $images = $this->getObject()->getImagesWithNumber();
      }

      $max = (int)sfConfig::get('app_community_topic_comment_max_image_file_num', 3);
      for ($i = 1; $i <= $max; $i++)
      {
        $key = 'photo_'.$i;

        if (isset($images[$i]))
        {
          $image = $images[$i];
        }
        else
        {
          $image = new CommunityTopicCommentImage();
          $image->setCommunityTopicComment($this->getObject());
          $image->setNumber($i);
        }
        $imageForm = new opCommunityTopicPluginImageForm($image);
        $imageForm->getWidgetSchema()->setFormFormatterName('list');
        $this->embedForm($key, $imageForm, '<ul id="community_topic_comment_'.$key.'">%content%</ul>');
      }
    }

    $this->widgetSchema->setLabel('body', sfContext::getInstance()->getI18N()->__('Comment'));
    $this->setValidator('body', new opValidatorString(array('rtrim' => true)));
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
  
  public function save($con = null)
  {
    $communityTopicComment = parent::save($con);
    $communityTopic = $communityTopicComment->getCommunityTopic();
    $communityTopic->setUpdatedAt($communityTopicComment->getCreatedAt());
    $communityTopic->save();

    if ($this->isNew())
    {
      opCommunityTopicToolkit::sendNotificationMail($communityTopic->getCommunity(), $communityTopic->getId(), 'topic', $communityTopicComment->getMember()->getName(), $communityTopic->getName(), $communityTopicComment->getBody());
    }

    return $communityTopicComment;
  }
}
