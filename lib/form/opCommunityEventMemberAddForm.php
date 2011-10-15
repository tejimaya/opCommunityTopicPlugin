<?php

class opCommunityEventMemberAddForm extends BaseForm
{
  public function configure()
  {
    $this->setWidget('community_event_member_add', new sfWidgetFormInput());
    $this->setValidator('community_event_member_add', new sfValidatorInteger());
    $this->widgetSchema->setLabel('community_event_member_add', 'Member ID');
  }
}

