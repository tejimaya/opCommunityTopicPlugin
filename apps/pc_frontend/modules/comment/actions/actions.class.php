<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * comment actions.
 *
 * @package    OpenPNE
 * @subpackage comment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 9301 2008-05-27 01:08:46Z dwhittle $
 */
class commentActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex($request)
  {
  }

 /**
  * Executes delete action
  *
  * @param sfRequest $request A request object
  */
  public function executeDelete($request)
  {
    $this->communityTopicId = $this->getRequestParameter('id');
    $this->communityTopic = CommunityTopicPeer::retrieveByPk($this->communityTopicId);
    $this->comment = CommunityTopicCommentPeer::retrieveByPk($request->getParameter('comment_id'));

    $this->comment->delete();
    $this->redirect('communityTopic/detail?id='.$this->communityTopicId);

  }
}
