<?php

/**
 * CommunityTopic form base class.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfPropelFormGeneratedTemplate.php 12815 2008-11-09 10:43:58Z fabien $
 */
class BaseCommunityTopicForm extends BaseFormPropel
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'community_id' => new sfWidgetFormPropelChoice(array('model' => 'Community', 'add_empty' => true)),
      'name'         => new sfWidgetFormTextarea(),
      'member_id'    => new sfWidgetFormPropelChoice(array('model' => 'Member', 'add_empty' => true)),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorPropelChoice(array('model' => 'CommunityTopic', 'column' => 'id', 'required' => false)),
      'community_id' => new sfValidatorPropelChoice(array('model' => 'Community', 'column' => 'id', 'required' => false)),
      'name'         => new sfValidatorString(array('required' => false)),
      'member_id'    => new sfValidatorPropelChoice(array('model' => 'Member', 'column' => 'id', 'required' => false)),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('community_topic[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityTopic';
  }


}
