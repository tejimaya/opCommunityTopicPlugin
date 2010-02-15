<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicAclBuilder
 *
 * @package    OpenPNE
 * @subpackage acl
 * @author     Kousuke Ebihara <ebihara@tejimaya.com>
 */
class opCommunityTopicAclBuilder extends opAclBuilder
{
  static protected
    $collection = array(),
    $resource = array();

  static public function getAcl()
  {
    $acl = new Zend_Acl();
    $acl->addRole(new Zend_Acl_Role('alien'));
    $acl->addRole(new Zend_Acl_Role('guest'), 'alien');
    $acl->addRole(new Zend_Acl_Role('member'), 'guest');
    $acl->addRole(new Zend_Acl_Role('admin'),  'member');
    $acl->addRole(new Zend_Acl_Role('writer'), 'member');

    return $acl;
  }

  static public function buildCollection($community, $targetMembers = array())
  {
    if (isset(self::$collection[$community->getId()]))
    {
      return self::$collection[$community->getId()];
    }

    $acl = self::getAcl();

    if ($community->getConfig('topic_authority') === 'admin_only')
    {
      $acl->allow('admin', null, 'add');
    }
    else
    {
      $acl->allow('member', null, 'add');
    }

    if ('auth_commu_member' === $community->getConfig('public_flag'))
    {
      $acl->allow('member', null, 'view');
    }
    else if ('public' === $community->getConfig('public_flag'))
    {
      $acl->allow('guest', null, 'view');
    }
    else
    {
      $acl->allow('alien', null, 'view');
    }

    foreach ($targetMembers as $member)
    {
      if ($member)
      {
        $role = new Zend_Acl_Role($member->getId());
        if ($community->isAdmin($member->getId()))
        {
          $acl->addRole($role, 'admin');
        }
        elseif ($community->isPrivilegeBelong($member->getId()))
        {
          $acl->addRole($role, 'member');
        }
        else
        {
          $acl->addRole($role, 'guest');
        }
      }
    }

    self::$collection[$community->getId()] = $acl;

    return $acl;
  }

  static public function buildResource($topic, $targetMembers)
  {
    if (isset(self::$resource[$topic->getId()]))
    {
      return self::$resource[$topic->getId()];
    }

    $acl = self::buildCollection($topic->getCommunity(), $targetMembers);
    $role = new Zend_Acl_Role($topic->getMemberId());
    if ($acl->hasRole($role) && $topic->getCommunity()->isPrivilegeBelong($topic->getMemberId()))
    {
      $acl->removeRole($role);
      $acl->addRole($role, 'writer');
    }

    $acl->allow('member', null, 'addComment');
    $acl->allow('admin', null, 'edit');
    $acl->allow('writer', null, 'edit');

    self::$resource[$topic->getId()] = $acl;

    return $acl;
  }
}
