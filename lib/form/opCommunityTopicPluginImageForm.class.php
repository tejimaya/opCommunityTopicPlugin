<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPluginImageForm
 *
 * @package    opCommunityTopicPluginImageForm
 * @subpackage form
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicPluginImageForm extends sfFormDoctrine
{
  protected $modelName;

  public function __construct($object = null, $options = array(), $CSRFSecret = null)
  {
    if ($object instanceof Doctrine_Record)
    {
      $this->modelName = get_class($object);
    }
    elseif (isset($options['modelName']))
    {
      $this->modelName = $options['modelName'];
    }

    if (!$this->modelName)
    {
      throw new LogicException('Specifying model name to the opCommunityTopicPluginImageForm is required.');
    }

    parent::__construct($object, $options, false);
  }

  public function setup()
  {
    parent::setup();

    $this->useFields();

    $options = array(
      'file_src'     => '',
      'is_image'     => true,
      'with_delete'  => true,
      'delete_label' => sfContext::getInstance()->getI18N()->__('remove the current photo'),
      'label'        => false,
      'edit_mode'    => !$this->isNew(),
    );

    $key = 'photo';

    if (!$this->isNew())
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
      $options['template'] = get_partial('communityTopic/formEditImage', array('image' => $this->getObject()));
      $this->setValidator($key.'_delete', new sfValidatorBoolean(array('required' => false)));
    }

    $this->setWidget($key, new sfWidgetFormInputFileEditable($options, array('size' => 40)));
    $this->setValidator($key, new opValidatorImageFile(array('required' => false)));
  }

  public function updateObject($values = null)
  {
    if ($values['photo'] instanceof sfValidatedFile)
    {
      if (!$this->isNew())
      {
        unset($this->getObject()->File);
      }

      $file = new File();
      $file->setFromValidatedFile($values['photo']);

      $this->getObject()->setFile($file);
    }
    else
    {
      if (!$this->isNew() && !empty($values['photo_delete']))
      {
        $this->getObject()->getFile()->delete();
      }
    }
  }

  public function getModelName()
  {
    return $this->modelName;
  }
}
