<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicToolkit
 *
 * @package    opCommunityTopicPlugin
 * @subpackage util
 * @author     Kousuke Ebihara <ebihara@php.net>
 */
class opCommunityTopicToolkit
{
  static public function sendNotificationMail(Community $community, $id, $type, $nickname, $subject, $body)
  {
    if (version_compare(OPENPNE_VERSION, '3.6beta1-dev', '<'))
    {
      return null;
    }

    sfContext::getInstance()->getConfiguration()->loadHelpers(array('opUtil'));

    $params = array(
      'community_name' => $community->getName(),
      'topic_name'     => $subject,
      'nickname'       => $nickname,
      'body'           => $body,
    );

    $rs = Doctrine::getTable('CommunityMember')->createQuery()
      ->where('community_id = ?', array($community->getId()))
      ->andWhere('is_receive_mail_pc = ? OR is_receive_mail_mobile = ?', array(true, true))
      ->execute(array(), Doctrine::HYDRATE_ON_DEMAND);

    foreach ($rs as $r)
    {
      $member = $r->getMember();
      $memberPcAddress = $member->getConfig('pc_address');
      $memberMobileAddress = $member->getConfig('mobile_address');
      $from = self::getPostMailAddress('mail_community_'.$type.'_comment_create', array(
        'id'   => $id,
        'hash' => $member->getMailAddressHash(),
      ));

      if ($r->getIsReceiveMailPc() && $memberPcAddress)
      {
        $params['url'] = app_url_for('pc_frontend', '@community'.ucfirst($type).'_show?id='.$id, true);
        opMailSend::sendTemplateMail('notifyCommunityPosting', $memberPcAddress, $from, $params);
      }

      if ($r->getIsReceiveMailMobile() && $memberMobileAddress)
      {
        $params['url'] = app_url_for('mobile_frontend', '@community'.ucfirst($type).'_show?id='.$id, true);
        opMailSend::sendTemplateMail('notifyCommunityPosting', $memberMobileAddress, $from, $params);
      }
    }
  }

  static public function getPostMailAddress($route, $params = array())
  {
    $configuration = sfContext::getInstance()->getConfiguration();
    $configPath = sfConfig::get('sf_plugins_dir').'/opCommunityTopicPlugin/apps/mobile_mail_frontend/config/routing.yml';

    $routing = new opMailRouting(new sfEventDispatcher());
    $config = new sfRoutingConfigHandler();
    $routes = $config->evaluate(array($configPath));

    $routing->setRoutes(array_merge(sfContext::getInstance()->getRouting()->getRoutes(), $routes));

    return $routing->generate($route, $params);
  }

  static public function getPublicCommunityIdList()
  {
    $result = array();

    $rs = Doctrine::getTable('CommunityConfig')->createQuery()
      ->select('id, community_id')
      ->where('name = ?', array('public_flag'))
      ->andWhere('value = ?', array('public'))
      ->execute(array(), Doctrine::HYDRATE_NONE);

    foreach ($rs as $r)
    {
      $result[] = $r[1];
    }

    return $result;
  }
}
