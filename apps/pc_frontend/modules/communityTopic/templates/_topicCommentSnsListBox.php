<?php if (count($communityTopic)): ?>
<?php slot('body') ?>
<?php foreach ($communityTopic as $topic): ?>
<li><span class="date"><?php echo op_format_date($topic->getUpdatedAt(), 'XShortDateJa') ?></span>
<?php echo sprintf('%s (%s)',
  link_to(sprintf('%s(%d)',
    op_truncate($topic->getName(), 36),
    $topic->getCommunityTopicComment()->count()
  ), '@communityTopic_show?id='.$topic->getId()),
  $topic->getCommunity()->getName()
) ?></li>
<?php endforeach ?>
<?php end_slot() ?>
<?php echo op_include_parts('topicRecentList', 'homeRecentList_'.$gadget->id, array(
  'title' => 'SNS全体のコミュニティ最新トピック',
  'listBody' => get_slot('body'),
  'moreInfo' => array(
    link_to(__('More'), array('sf_route' => 'communityTopic_search_all')),
  ),
)) ?>
<?php endif ?>
