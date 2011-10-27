<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopic
 * 
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityTopic
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class PluginCommunityTopic extends BaseCommunityTopic
{
  public function isEditable($memberId)
  {
    if (!$this->getCommunity()->isPrivilegeBelong($memberId))
    {
      return false;
    }

    return ($this->getMemberId() === $memberId || $this->getCommunity()->isAdmin($memberId));
  }

  public function isCreatableCommunityTopicComment($memberId)
  {
    return $this->getCommunity()->isPrivilegeBelong($memberId);
  }

  public function isTopicModified()
  {
    $modified = $this->getModified();
    return (isset($modified['name']) || isset($modified['body']));
  }

  public function preSave($event)
  {
    $modified = $this->getModified();
    if ($this->isTopicModified() && empty($modified['topic_updated_at']))
    {
      $this->setTopicUpdatedAt(date('Y-m-d H:i:s', time()));
    }
  }

  // for pager
  public function getImageFilename()
  {
    return $this->getCommunity()->getImageFilename();
  }

  public function getImagesWithNumber()
  {
    $images = $this->getImages();
    $result = array();
    foreach ($images as $image)
    {
      $result[$image->number] = $image;
    }

    return $result;
  }

  public function postInsert($event)
  {
    if (Doctrine::getTable('SnsConfig')->get('op_community_topic_plugin_update_activity', false)
      && defined('OPENPNE_VERSION') && version_compare(OPENPNE_VERSION, '3.6beta1-dev', '>='))
    {
      $body = '[%Community% Topic] ('.$this->getCommunity()->getName().' %community%) '.$this->name;
      $options = array(
        'public_flag' => $this->getCommunity()->getConfig('public_flag') === 'public' ? 1 : 3,
        'uri' => '@communityTopic_show?id='.$this->id,
        'source' => 'CommunityTopic',
        'template' => 'community_topic',
        'template_param' => array('%1%' => $this->getCommunity()->getName(), '%2%' => $this->name),
      );
      Doctrine::getTable('ActivityData')->updateActivity($this->member_id, $body, $options);
    }
  }
}
