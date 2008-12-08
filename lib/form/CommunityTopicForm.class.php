<?php

/**
 * CommunityTopic form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormTemplate.php 10377 2008-07-21 07:10:32Z dwhittle $
 */
class CommunityTopicForm extends BaseCommunityTopicForm
{
  public function configure()
  {
    $this->widgetSchema['community_id'] = new sfWidgetFormInputHidden();
    $this->widgetSchema['member_id'] = new sfWidgetFormInputHidden();
    $this->setDefaults(array('community_id' => $this->getOption('community_id'), 'member_id' => sfContext::getInstance()->getUser()->getMemberId()));
  }

  public function save($con = null)
  {
    $community_topic = parent::save($con);
/*
    if ($this->isNew()) {
      $communityMember = new CommunityTopic();
      $communityMember->setMemberId(sfContext::getInstance()->getUser()->getMemberId());
      $communityMember->setCommunityId($community_topic->getId());
      $communityMember->save();
    }
*/

//    print "save";
    return $community_topic;
  }
}
