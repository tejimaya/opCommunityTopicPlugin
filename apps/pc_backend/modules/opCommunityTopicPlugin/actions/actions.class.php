<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicPlugin actions.
 *
 * @package    OpenPNE
 * @subpackage opCommunityTopicPlugin
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicPluginActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->form = new opCommunityTopicPluginConfigurationForm();

    if ($request->isMethod(sfRequest::POST))
    {
      $this->form->bind($request->getParameter($this->form->getName()));
      if ($this->form->isValid())
      {
        $this->form->save();

        $this->getUser()->setFlash('notice', 'Saved configuration successfully.');

        $this->redirect('opCommunityTopicPlugin/index');
      }
    }
  }
}
