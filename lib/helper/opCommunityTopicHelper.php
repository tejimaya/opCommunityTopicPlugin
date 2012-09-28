<?php

/**
 * This file is part of the OpenPNE package.
 * (c) OpenPNE Project (http://www.openpne.jp/)
 *
 * For the full copyright and license information, please view the LICENSE
 * file and the NOTICE file that were distributed with this source code.
 */

/**
 * opCommunityTopicHelper.
 *
 * @package    OpenPNE
 * @subpackage helper
 * @author     Yuya Watanabe <watanabe@openpne.jp>
 */

function op_community_topic_link_to_member(sfOutputEscaper $member)
{
  if (function_exists('op_link_to_member'))
  {
    return op_link_to_member($member);
  }

  if ($member && $member->id)
  {
    if (sfConfig::get('sf_app') == 'mobile_frontend')
    {
      $internal_uri = '@member_profile';
    }
    else
    {
      $internal_uri = '@obj_member_profile';
    }
    return link_to($member->name, sprintf('%s?id=%d', $internal_uri, $member->id));
  }

  return '';
}

function op_api_community_topic($topic)
{
  return array(
    'id'             => $topic->getId(),
    'community_id'   => $topic->getCommunityId(),
    'community_name' => $topic->getCommunity()->getName(),
    'name'           => $topic->getName(),
    'member'         => op_api_member($topic->getMember()),
    'body'           => nl2br($topic->getBody()),
    'created_at'     => $topic->getCreatedAt(),
  );
}

function op_api_community_topic_mini($topic)
{
  return array(
    'id'             => $topic->getId(),
    'community_id'   => $topic->getCommunityId(),
    'community_name' => $topic->getCommunity()->getName(),
    'name'           => $topic->getName(),
    'body'           => nl2br($topic->getBody()),
    'created_at'     => $topic->getCreatedAt(),
  );
}

function op_api_community_topic_comment($comment)
{
  return array(
    'id'         => $comment->getId(),
    'body'       => nl2br($comment->getBody()),
    'member'     => op_api_member($comment->getMember()),
    'created_at' => $comment->getCreatedAt(),
  );
}

function op_api_topic_image($image)
{
  if($image)
  {
    return array(
      'filename' => sf_image_path($image->getFile()->getName()),
      'imagetag' => image_tag_sf_image($image->getFile()->getName(), array('size' => '120x120'))
    );
  }
}
