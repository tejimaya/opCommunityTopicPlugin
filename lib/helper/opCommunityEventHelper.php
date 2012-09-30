<?php
function op_api_community_event($event)
{
  return array(
    'id'             => $event->getId(),
    'community_id'   => $event->getCommunityId(),
    'community_name' => $event->getCommunity()->getName(),
    'name'           => $event->getName(),
    'member'         => op_api_member($event->getMember()),
    'body'           => nl2br($event->getBody()),
    'created_at'     => $event->getCreatedAt(),
  );
}

function op_api_community_event_mini($event)
{
  return array(
    'id'             => $event->getId(),
    'community_id'   => $event->getCommunityId(),
    'community_name' => $event->getCommunity()->getName(),
    'name'           => $event->getName(),
    'body'           => nl2br($event->getBody()),
    'created_at'     => $event->getCreatedAt(),
  );
}

function op_api_community_event_comment($comment)
{
  return array(
    'id'         => $comment->getId(),
    'body'       => nl2br($comment->getBody()),
    'member'     => op_api_member($comment->getMember()),
    'created_at' => $comment->getCreatedAt(),
  );
}

