<?php

/**
 * PluginCommunityTopicCommentImage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginCommunityTopicCommentImageForm extends BaseCommunityTopicCommentImageForm
{
  public function setup()
  {
    parent::setup();

    unset($this['id']);
    $this->useFields();

    $key = 'photo';

    $options = array(
        'file_src'     => '',
        'is_image'     => true,
        'label'        => false,
        'edit_mode'    => false,
        );

    $this->setWidget($key, new sfWidgetFormInputFileEditable($options, array('size' => 40)));
    $this->setValidator($key, new opValidatorImageFile(array('required' => false)));
  }

  public function updateObject($values = null)
  {
    if ($values['photo'] instanceof sfValidatedFile)
    {
      $file = new File();
      $file->setFromValidatedFile($values['photo']);

      $this->getObject()->setFile($file);
    }
    else
    {
      $this->getObject()->setFile(null);
    }
  }
}
