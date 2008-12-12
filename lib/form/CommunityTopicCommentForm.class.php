<?php

/**
 * CommunityTopicComment form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CommunityTopicCommentForm extends BaseCommunityTopicCommentForm
{
  public function configure()
  {
    $this->widgetSchema['community_topic_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['member_id'] = new sfWidgetFormInputHidden();
    $this->setDefaults(array('community_topic_id' => $this->getOption('community_topic_id'), 'member_id' => sfContext::getInstance()->getUser()->getMemberId()));
  }

  public function save($con = null)
  {
    $community_topic_comment = parent::save($con);
/*
    if ($this->isNew()) {
      $communityMember = new CommunityTopic();
      $communityMember->setMemberId(sfContext::getInstance()->getUser()->getMemberId());
      $communityMember->setCommunityId($community_topic->getId());
      $communityMember->save();
    }
*/

//    print "save";
    return $community_topic_comment;
  }
}
