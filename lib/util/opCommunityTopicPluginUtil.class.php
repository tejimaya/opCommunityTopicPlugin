<?php

class opCommunityTopicPluginUtil
{
  public static function sendNewCommentNotification($fromMember, $toMember, $topicId){
    $rootPath = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();
    $url = $rootPath.'/communityTopic/'.$topicId;

    sfApplicationConfiguration::getActive()->loadHelpers(array('I18N'));
    $message = format_number_choice('[1]1 topic has new comments|(1,Inf]%1% topics have new comments', array('%1%'=>'1'), 1);
    
    opNotificationCenter::notify($fromMember, $toMember, $message, array('category'=>'other', 'url'=>$url, 'icon_url'=>null));
  }
}
