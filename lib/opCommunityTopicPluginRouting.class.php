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
      'communityTopic_list_community' => new sfPropelRoute(
        '/communityTopic/listCommunity/:id',
        array('module' => 'communityTopic', 'action' => 'listCommunity'),
        array('id' => '\d+'),
        array('model' => 'Community', 'type' => 'object')
      ),
      'communityTopic_show' => new sfPropelRoute(
        '/communityTopic/:id',
        array('module' => 'communityTopic', 'action' => 'show'),
        array('id' => '\d+'),
        array('model' => 'CommunityTopic', 'type' => 'object')
      ),

      'communityTopic_new' => new sfPropelRoute(
        '/communityTopic/new/:id',
        array('module' => 'communityTopic', 'action' => 'new'),
        array('id' => '\d+'),
        array('model' => 'Community', 'type' => 'object')
      ),
      'communityTopic_create' => new sfPropelRoute(
        '/communityTopic/create/:id',
        array('module' => 'communityTopic', 'action' => 'create'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'Community', 'type' => 'object')
      ),
      'communityTopic_edit' => new sfPropelRoute(
        '/communityTopic/edit/:id',
        array('module' => 'communityTopic', 'action' => 'edit'),
        array('id' => '\d+'),
        array('model' => 'CommunityTopic', 'type' => 'object')
      ),
      'communityTopic_update' => new sfPropelRoute(
        '/communityTopic/update/:id',
        array('module' => 'communityTopic', 'action' => 'update'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'CommunityTopic', 'type' => 'object')
      ),
      'communityTopic_delete_confirm' => new sfPropelRoute(
        '/communityTopic/deleteConfirm/:id',
        array('module' => 'communityTopic', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'CommunityTopic', 'type' => 'object')
      ),
      'communityTopic_delete' => new sfPropelRoute(
        '/communityTopic/delete/:id',
        array('module' => 'communityTopic', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'CommunityTopic', 'type' => 'object')
      ),

      'communityTopic_comment_create' => new sfPropelRoute(
        '/communityTopic/:id/comment/create',
        array('module' => 'communityTopicComment', 'action' => 'create'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'CommunityTopic', 'type' => 'object')
      ),
      'communityTopic_comment_delete_confirm' => new sfPropelRoute(
        '/communityTopic/comment/deleteConfirm/:id',
        array('module' => 'communityTopicComment', 'action' => 'deleteConfirm'),
        array('id' => '\d+'),
        array('model' => 'CommunityTopicComment', 'type' => 'object')
      ),
      'communityTopic_comment_delete' => new sfPropelRoute(
        '/communityTopic/comment/delete/:id',
        array('module' => 'communityTopicComment', 'action' => 'delete'),
        array('id' => '\d+', 'sf_method' => array('post')),
        array('model' => 'CommunityTopicComment', 'type' => 'object')
      ),
/*
      'communityTopic_nodefaults' => new sfRoute(
        '/communityTopic/*',
        array('module' => 'default', 'action' => 'error')
      ),
      */
    );

    $routes = array_reverse($routes);
    foreach ($routes as $name => $route)
    {
      $routing->prependRoute($name, $route);
    }
  }
}
