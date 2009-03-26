<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityTopic routing.
 *
 * @package    OpenPNE
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 * @author     Rimpei Ogawa <ogawa@tejimaya.com>
 */
class opCommunityTopicPluginRouting
{
  static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
  {
    $routing = $event->getSubject();

    $routes = array(
      'topic' => new opCommunityTopicPluginRouteCollection(array('name' => 'topic')),
      'event' => new opCommunityTopicPluginRouteCollection(array('name' => 'event')),

      'communityEvent_memberList' => new sfPropelRoute(
        '/communityEvent/:id/memberList',
        array('module' => 'communityEvent', 'action' => 'memberList'),
        array('id' => '\d+'),
        array('model' => 'CommunityEvent', 'type' => 'object')
      ),

      'communityTopic_recently_topic_list' => new sfRoute(
        '/communityTopic/recentlyTopicList',
        array('module' => 'communityTopic', 'action' => 'recentlyTopicList')
      ),

      'communityEvent_recently_event_list' => new sfRoute(
        '/communityEvent/recentlyEventList',
        array('module' => 'communityEvent', 'action' => 'recentlyEventList')
      ),

      'communityTopic_nodefaults' => new sfRoute(
        '/communityTopic/*',
        array('module' => 'default', 'action' => 'error')
      ),
    );

    $routes = array_reverse($routes);
    foreach ($routes as $name => $route)
    {
      $routing->prependRoute($name, $route);
    }
  }
}
