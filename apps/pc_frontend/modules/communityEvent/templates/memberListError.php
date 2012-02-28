<?php op_include_box('noMembers', __('Nobody joins this event.'), array('title' => __('Event Members'))) ?>

<?php use_helper('Javascript') ?>
<?php op_include_line('backLink', link_to_function(__('Back to previous page'), 'history.back()')) ?>
