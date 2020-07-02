<?php
function op_api_community_event($event)
{
  return array(
    'id'                   => $event->getId(),
    'community_id'         => $event->getCommunityId(),
    'community_name'       => $event->getCommunity()->getName(),
    'member'               => op_api_member($event->getMember()),
    'name'                 => $event->getName(),
    'body'                 => nl2br(op_auto_link_text($event->getBody())),
    'open_date'            => $event->getOpenDate(),
    'open_date_comment'    => $event->getOpenDateComment(),
    'area'                 => nl2br(op_auto_link_text($event->getArea())),
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
    'body'           => nl2br(op_auto_link_text($event->getBody())),
    'created_at'     => $event->getCreatedAt(),
  );
}

function op_api_community_event_comment($comment)
{
  return array(
    'id'         => $comment->getId(),
    'body'       => nl2br(op_auto_link_text($comment->getBody())),
    'member'     => op_api_member($comment->getMember()),
    'created_at' => $comment->getCreatedAt(),
  );
}
