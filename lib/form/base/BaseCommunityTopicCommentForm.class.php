<?php

/**
 * CommunityTopicComment form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseCommunityTopicCommentForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'community_topic_id' => new sfWidgetFormPropelChoice(array('model' => 'CommunityTopic', 'add_empty' => true)),
      'member_id'          => new sfWidgetFormPropelChoice(array('model' => 'Member', 'add_empty' => true)),
      'body'               => new sfWidgetFormTextarea(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorPropelChoice(array('model' => 'CommunityTopicComment', 'column' => 'id', 'required' => false)),
      'community_topic_id' => new sfValidatorPropelChoice(array('model' => 'CommunityTopic', 'column' => 'id', 'required' => false)),
      'member_id'          => new sfValidatorPropelChoice(array('model' => 'Member', 'column' => 'id', 'required' => false)),
      'body'               => new sfValidatorString(array('required' => false)),
      'created_at'         => new sfValidatorDateTime(array('required' => false)),
      'updated_at'         => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('community_topic_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityTopicComment';
  }


}
