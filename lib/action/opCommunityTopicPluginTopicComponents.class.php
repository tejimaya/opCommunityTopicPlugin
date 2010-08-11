<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginTopicComponents
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     masabon
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 * @author     Shogo Kawahara <kawahara@tejimaya.net>
 */
abstract class opCommunityTopicPluginTopicComponents extends sfComponents
{
  public function executeCommunityTopicList()
  {
    $publicFlag = Doctrine::getTable('CommunityConfig')->retrieveByNameAndCommunityId('public_flag', $this->community->getId());
    $isBelong = $this->community->isPrivilegeBelong($this->getUser()->getMemberId());
    $this->hasPermission = true;

    if ($publicFlag && !$isBelong && $publicFlag->getValue() !== 'public')
    {
      $this->hasPermission = true;
      return sfView::SUCCESS;
    }

    $this->communityTopics = Doctrine::getTable('CommunityTopic')->getTopics($this->community->getId());
  }

  public function executeTopicCommentListBox()
  {
    $this->communityTopic = Doctrine::getTable('CommunityTopic')->retrivesByMemberId($this->getUser()->getMember()->getId(), $this->gadget->getConfig('col'));
  }

  public function executeTopSearchForm()
  {
    $this->topicSearchCaption = sfContext::getInstance()->getI18N()->__('Topic');
    $this->eventSearchCaption = sfContext::getInstance()->getI18N()->__('Event');
  }

  public function executeConfigNotificationMail($request)
  {
    try
    {
      $this->form = new opConfigCommunityTopicNotificationMailForm($request['id']);
    }
    catch (RuntimeException $e)
    {
      // do nothing.
    }
  }
}
