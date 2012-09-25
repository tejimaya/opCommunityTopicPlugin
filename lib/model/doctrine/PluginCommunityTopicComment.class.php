<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * PluginCommunityTopicComment
 * 
 * @package    opCommunityTopicPlugin
 * @subpackage CommunityTopicCommnet
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class PluginCommunityTopicComment extends BaseCommunityTopicComment
{
  public function isDeletable($memberId)
  {
    return ($this->getMemberId() === $memberId || $this->getCommunityTopic()->isEditable($memberId));
  }

  public function preSave($event)
  {
    $modified = $this->getModified();
    if ($this->isNew() && empty($modified['number']))
    {
      $this->getCommunityTopic()->setTopicUpdatedAt(date('Y-m-d H:i:s', time()));
      $this->setNumber(Doctrine::getTable('CommunityTopicComment')->getMaxNumber($this->getCommunityTopicId()) + 1);
    }
  }

  public function postSave($event)
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
    $message = format_number_choice('[1]1 topic has new comments|(1,Inf]%1% topics have new comments', array('%1%'=>'1'), 1);
    $fromMember = Doctrine::getTable('Member')->findOneById($this->getMemberId());

    //トピック主に通知を飛ばす
    if ($this->getMemberId() !== $this->getCommunityTopic()->getMemberId())
    {

      opNotificationCenter::notify($fromMember, $this->getCommunityTopic()->getMember(), $message, array('category'=>'other', 'url'=>'/communityTopic/'.$this->getCommunityTopic()->getId()));

    }
  
    //同じトピックにコメントをしている人に通知を飛ばす
    $comments = $this->getCommunityTopic()->getCommunityTopicComment();
    $toMembers = array();
    foreach($comments as $comment)
    {
      if(false == array_key_exists($comment->getMemberId(), $toMembers)
        && $comment->getMemberId() !== $this->getCommunityTopic()->getMemberId()
        && $comment->getMemberId() !== $this->getMemberId()
      )
      {
        $toMembers[$comment->getMemberId()] = $comment->getMember();
      }
    }
    foreach($toMembers as $toMember)
    {
      opNotificationCenter::notify($fromMember, $toMember, $message, array('category'=>'other', 'url'=>'/communityTopic/'.$this->getCommunityTopic()->getId()));
    }
    
  }
}
