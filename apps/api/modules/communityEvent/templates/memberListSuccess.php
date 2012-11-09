<?php

$data = array();
if (!is_null($eventMembers))
{
  foreach ($eventMembers as $member)
  {
    $data[] = op_api_member($member);
  }
}

return array(
  'status' => 'success',
  'data' => $data,
);
