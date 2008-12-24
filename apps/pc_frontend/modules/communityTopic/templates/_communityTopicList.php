<?php use_helper('Pagination', 'Date'); ?>

<?php
$communityConfigPublicFlag = CommunityConfigPeer::retrieveByNameAndCommunityId('public_flag', $community->getId());
if ($communityConfigPublicFlag === null || $community->isPrivilegeBelong($sf_user->getMemberId()) || $communityConfigPublicFlag->getValue() === 'public') :
?>
<tr>
<th>コミュニティ掲示板</th>
<td>
<ul>
<?php
$communityTopics = CommunityTopicPeer::getTopics($community->getId());
if ($communityTopics) :
for ($i = 0; $i < 7; $i++) :
?>
<li>
<?php
echo format_datetime($communityTopics[$i]->getUpdatedAt(), 'f');
echo ' ';
echo link_to($communityTopics[$i]->getName().'('.$communityTopics[$i]->countCommunityTopicComments().')', 'communityTopic/detail?id='.$communityTopics[$i]->getId());
?>
</li>
<?php endfor; ?>
<li><?php echo link_to('もっと読む', 'communityTopic/list?community_id='.$community->getId()); ?></li>
<?php endif; ?>
<li><?php echo link_to('トピック作成', 'communityTopic/edit?community_id='.$community->getId()); ?></li>
</ul>
</td>
</tr>
<?php endif; ?>
