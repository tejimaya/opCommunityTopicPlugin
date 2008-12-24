<?php
$communityConfigPublicFlag = CommunityConfigPeer::retrieveByNameAndCommunityId('public_flag', $community->getId());
if ($communityConfigPublicFlag === null || $community->isPrivilegeBelong($sf_user->getMemberId()) || $communityConfigPublicFlag->getValue() === 'public') :
?>
<tr>
<th>コミュニティ掲示板</th>
<td>
<ul>
<?php
$list = CommunityTopicPeer::retrieveByCommunityId($community->getId());
foreach ($list as $value):
?>
<li>
<?php
echo $value->getCreatedAt();
echo ' ';
echo link_to($value->getName(), 'communityTopic/detail?id='.$value->getId());
echo ' ';
echo link_to('編集', 'communityTopic/edit?id='.$value->getId());
echo ' ';
echo link_to('削除', 'communityTopic/delete?id='.$value->getId())
?>
</li>
<?php endforeach; ?>
<li>もっと読む</li>
<li><?php echo link_to('トピック追加', 'communityTopic/edit?community_id='.$community->getId()) ?></li>
</ul>
</td>
</tr>
<?php endif; ?>
