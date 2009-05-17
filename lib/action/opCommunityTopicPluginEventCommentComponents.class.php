<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * communityEventComment components.
 *
 * @package    OpenPNE
 * @subpackage action
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
abstract class opCommunityEventCommentComponents extends sfComponents
{
  public function executeList($request)
  {
    if (!$this->size)
    {
      $this->size = 20;
    }

    $this->commentPager = 
      Doctrine::getTable('CommunityEventComment')->getCommunityEventCommentListPager(
      $this->communityEvent->getId(),
      $request->getParameter('page', 1),
      $this->size,
      $request->getParameter('order', 'DESC')
    );
  }
}
