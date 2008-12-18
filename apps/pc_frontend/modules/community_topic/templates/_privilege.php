<?php
$openRange = array('public' => '全員に公開', 'auth_commu_member' => 'コミュニティ参加者にのみ公開');
$createPrivilege = array('public' => 'コミュニティ参加者全員が作成可能', 'admin_only' => 'コミュニティ管理者のみ作成可能');
$openRangeRadio = new sfWidgetFormSelectRadio(array('choices' => $openRange));
$createPrivilegeRadio = new sfWidgetFormSelectRadio(array('choices' => $createPrivilege));
?>
<tr>
<th>トピック公開範囲</th>
<td>
<?php echo $openRangeRadio->render('community[config][public_flag]', 'public'); ?>
</td>
</tr>
<tr>
<th>トピック作成権限</th>
<td>
<?php echo $createPrivilegeRadio->render('community[config][topic_authority]', 'public'); ?>
</td>
</tr>
