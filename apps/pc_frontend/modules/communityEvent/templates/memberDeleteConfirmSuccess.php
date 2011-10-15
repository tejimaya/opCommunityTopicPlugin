<?php
op_include_parts('buttonBox', 'toDelete', array(
  'title'  => __('Delete the member from this event?'),
  'button' => __('Delete'),
  'url' => url_for('@communityEvent_memberDelete?community_event_id='.$communityEventId.'&member_id='.$memberId),
  'method' => 'get',
));

use_helper('Javascript');
op_include_line('backLink', link_to_function(__('Back to previous page'), 'history.back()'));
