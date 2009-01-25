<?php
$options = array();
$options['title'] = 'トピック作成';
$options['url'] = '@communityTopic_create?id='.$community->getId();
op_include_form('formCommunityTopic', $form, $options);
?>
