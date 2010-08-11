<?php if (version_compare(OPENPNE_VERSION, '3.6beta1-dev', '>=') && $form): ?>
<?php op_include_form('configNotificationMailBox', $form, array(
  'mark_required_field' => false,
  'url'                 => url_for('@config_community_topic_notification_mail?id='.$sf_request->getParameter('id')),
  'button'              => __('Save'),
)); ?>
<?php endif; ?>
