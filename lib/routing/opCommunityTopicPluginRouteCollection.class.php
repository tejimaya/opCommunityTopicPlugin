<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * CommunityTopicPlugin route collection.
 *
 * @package    OpenPNE
 * @subpackage routing
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class opCommunityTopicPluginRouteCollection extends sfRouteCollection
{
  protected $templates = array(
    'list_community' => array(
      'url'          => '/listCommunity/:id',
      'action'       => 'listCommunity',
      'requirements' => array('id' => '\d+'),
      'option'       => array('model' => 'Community', 'type' => 'object'),
    ),
    'show' => array(
      'url'          => '/:id',
      'action'       => 'show',
      'requirements' => array('id' => '\d+'),
      'option'       => array('model' => 'CommunityTopic', 'type' => 'object', 'privilege' => 'view'),
    ),
    'new' => array(
      'url'          => '/new/:id',
      'action'       => 'new',
      'requirements' => array('id' => '\d+'),
      'option'       => array('model' => 'Community', 'type' => 'object'),
    ),
    'create' => array(
      'url'          => '/create/:id',
      'action'       => 'create',
      'requirements' => array('id' => '\d+', 'sf_method' => array('post')),
      'option'       => array('model' => 'Community', 'type' => 'object'),
    ),
    'edit' => array(
      'url'          => '/edit/:id',
      'action'       => 'edit',
      'requirements' => array('id' => '\d+'),
      'option'       => array('model' => 'CommunityTopic', 'type' => 'object', 'privilege' => 'edit'),
    ),
    'update' => array(
      'url'          => '/update/:id',
      'action'       => 'update',
      'requirements' => array('id' => '\d+', 'sf_method' => array('post')),
      'option'       => array('model' => 'CommunityTopic', 'type' => 'object', 'privilege' => 'edit'),
    ),
    'delete_confirm' => array(
      'url'          => '/deleteConfirm/:id',
      'action'       => 'deleteConfirm',
      'requirements' => array('id' => '\d+'),
      'option'       => array('model' => 'CommunityTopic', 'type' => 'object', 'privilege' => 'edit'),
    ),
    'delete' => array(
      'url'          => '/delete/:id',
      'action'       => 'delete',
      'requirements' => array('id' => '\d+', 'sf_method' => array('post')),
      'option'       => array('model' => 'CommunityTopic', 'type' => 'object', 'privilege' => 'edit'),
    ),
    'comment_create' => array(
      'url'          => '/:id/comment/create',
      'module'       => 'comment',
      'action'       => 'create',
      'requirements' => array('id' => '\d+', 'sf_method' => array('post')),
      'option'       => array('model' => 'CommunityTopic', 'type' => 'object'),
    ),
    'comment_delete_confirm' => array(
      'url'          => '/comment/deleteConfirm/:id',
      'module'       => 'comment',
      'action'       => 'deleteConfirm',
      'requirements' => array('id' => '\d+'),
      'option'       => array('model' => 'CommunityTopicComment', 'type' => 'object'),
    ),
    'comment_delete' => array(
      'url'          => '/comment/delete/:id',
      'module'       => 'comment',
      'action'       => 'delete',
      'requirements' => array('id' => '\d+', 'sf_method' => array('post')),
      'option'       => array('model' => 'CommunityTopicComment', 'type' => 'object'),
    ),
  );

  public function __construct(array $options)
  {
    parent::__construct($options);
    $this->generateRoutes($options['name']);
  }

  protected function generateRoutes($type)
  {
    foreach ($this->templates as $name => $template)
    {
      $prefix = 'community'.ucfirst($type);

      $routeClass = 'sfRoute';
      if (isset($template['option']['model']))
      {
        if (isset($template['option']['privilege']))
        {
          $routeClass = 'opDynamicAclRoute';
        }
        else
        {
          $routeClass = 'sfDoctrineRoute';
        }
        $template['option']['model'] = str_replace('Topic', ucfirst($type), $template['option']['model']);
      }

      $module = $prefix;
      if (isset($template['module']))
      {
        $module .= ucfirst($template['module']);
      }

      $requirements = array();
      if (isset($template['requirements']))
      {
        $requirements = $template['requirements'];
      }

      $option = array();
      if (isset($template['option']))
      {
        $option = $template['option'];
      }

      $this->routes[$prefix.'_'.$name] = new $routeClass(
        '/'.$prefix.$template['url'],
        array('module' => $module, 'action' => $template['action']),
        $requirements,
        $option
      );
    }

    $this->routes = array_reverse($this->routes);
  }
}
