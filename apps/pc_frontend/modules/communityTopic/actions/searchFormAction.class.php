<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * searchForm action.
 *
 * @package    OpenPNE
 * @subpackage communityTopic
 * @author     Yoichiro SAKURAI <saku2saku@gmail.com>
 */
class searchFormAction extends sfAction
{
 /**
  * Executes this action
  *
  * @param sfRequest $request A request object
  */
  public function execute($request)
  {
    $request->setParameter('type', $request->getParameter('search_module'));

    $this->forward('communityTopic', 'search');
  }
}
