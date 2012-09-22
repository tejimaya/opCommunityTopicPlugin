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
    'id'   => $topic->getId(),
    'name' => $topic->getName(),
    'body' => $topic->getBody(),
    'latest_comment' => $latest_comment['body'],
    'created_at' => $topic->getCreatedAt(),
    'ago'        => op_format_activity_time(strtotime($topic->getTopicUpdatedAt())),
  );
}

function op_api_community_topic_comment($comment)
{
  return array(
    'id'   => $comment->getId(),
    'body' => $comment->getBody(),
    'member'=> op_api_member($comment->getMember()),
    'created_at' => $comment->getCreatedAt(),
    'ago'        => op_format_activity_time(strtotime($comment->getCreatedAt())),
  );
}
