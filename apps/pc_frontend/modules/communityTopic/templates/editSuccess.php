<?php
$options = array();
$options['title'] = 'トピック編集';
$options['url'] = '@communityTopic_update?id='.$communityTopic->getId();
op_include_form('formCommunityTopic', $form, $options);
?>

<?php
op_include_box('toDelete', link_to(__('削除'), 'communityTopic_delete_confirm', $communityTopic), array('title' => __('トピックと書き込みを削除する')));
?>
