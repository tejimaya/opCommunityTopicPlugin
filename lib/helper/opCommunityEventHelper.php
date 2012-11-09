<?php
function op_api_community_event($event)
{
  return array(
    'id'                   => $event->getId(),
    'community_id'         => $event->getCommunityId(),
    'community_name'       => $event->getCommunity()->getName(),
    'member'               => op_api_member($event->getMember()),
    'name'                 => $event->getName(),
    'body'                 => nl2br($event->getBody()),
    'open_date'            => $event->getOpenDate(),
    'open_date_comment'    => $event->getOpenDateComment(),
    'area'                 => $event->getArea(),
    'application_deadline' => $event->getApplicationDeadline(),
    'capacity'             => $event->getCapacity(),
    'participants'         => count($event->getCommunityEventMember()),
    'created_at'           => $event->getCreatedAt(),
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
