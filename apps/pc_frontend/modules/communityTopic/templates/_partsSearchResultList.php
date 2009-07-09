<div class="dparts searchResultList"><div class="parts">
<div class="partsHeading">
<h3><?php echo $title ?></h3>
</div>

<?php slot('pager') ?>
<?php op_include_pager_navigation($pager, $link_to_page, array('use_current_query_string' => true)); ?>
<?php end_slot(); ?>
<?php include_slot('pager') ?>

<div class="block">
<?php foreach ($pager->getResults() as $key => $result): ?>
<?php $row = $list->getRaw($key); ?>
<div class="ditem"><div class="item"><table><tbody><tr>
<td rowspan="<?php echo count($row) + 1 ?>" class="photo">
<?php echo link_to(image_tag_sf_image($result->getCommunity()->getImageFilename(), array('size' => '76x76')).'<br />詳細を見る', sprintf($link_to_detail, $result->getCommunity()->getId())) ?>
</td>
<th>
<?php
reset($row);
echo key($row);
?>
</th><td>
<?php echo array_shift($row); ?>
</td>
</tr>
<?php foreach ($row as $caption => $item) : ?>
<tr>
<th><?php echo $caption ?></th><td><?php echo op_truncate($item, 36, '', 3) ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div></div>
<?php endforeach; ?>
</div>
</div>

<?php include_slot('pager') ?>
</div>
