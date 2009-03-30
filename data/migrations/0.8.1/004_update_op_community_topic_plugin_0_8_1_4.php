<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

class update_op_community_topic_plugin_0_8_1_4 extends opMigration
{
  public function up()
  {
    $eventNavigation = new Navigation();
    $eventNavigation->setType('community');
    $eventNavigation->setUri('communityEvent/listCommunity');
    $eventNavigation->setSortOrder(6);
    $eventNavigation->setCaption('Events', 'en');
    $eventNavigation->setCaption('イベントリスト', 'ja_JP');

    $gadget = new Gadget();
    $gadget->setType('contents');
    $gadget->setName('recentCommunityEventComment');
    $gadget->setSortOrder(132);
    $gadget->save();


    $gadget = new Gadget();
    $gadget->setType('mobileContents');
    $gadget->setName('recentCommunityEventComment');
    $gadget->setSortOrder(111);
    $gadget->save();
  }

  public function down()
  {
    $c = new Criteria();
    $c->add(NavigationPeer::TYPE, 'community');
    $c->add(NavigationPeer::URI, 'communityEvent/listCommunity');
    NavigationPeer::doDelete($c);

    $c = new Criteria();
    $c->add(GadgetPeer::NAME, 'recentCommunityEventComment');
    GadgetPeer::doDelete($c);
  }
}
