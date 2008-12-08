<?php
//$list = array('てすと' => 'tet');
//include_list_box('topic', $list, array('title' => 'トピック'))
?>

<?php
//  $test = CommunityTopicPeer::retrieveByPk(1);
//  print_r($test);
//  print '<tr><th>test</th><td>tetetetetete</td></tr>';
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
echo link_to($value->getName(), 'community_topic/edit?id='.$value->getId())
?>
</li>
<?php endforeach; ?>
<li>もっと読む</li>
<li><?php echo link_to('トピック追加', 'community_topic/edit?community_id='.$community->getId()) ?></li>
</ul>
</td>
</tr>
