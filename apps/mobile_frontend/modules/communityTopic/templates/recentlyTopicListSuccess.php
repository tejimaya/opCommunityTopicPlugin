<?php op_mobile_page_title(__('Recently Posted Community Topics')) ?>

<?php if ($pager->getNbResults()): ?>
<?php use_helper('Date') ?>

<center>
<?php echo pager_total($pager) ?>
</center>

<?php
$list = array();
foreach ($pager->getResults() as $topic)
{
  $list[] = sprintf("%s<br>%s (%s)",
    op_format_date($topic->getUpdatedAt(), 'XDateTime'),
    link_to(sprintf("%s(%d)",
        op_truncate($topic->getName(), 28),
        $topic->getCommunityTopicComment()->count()
      ),'communityTopic_show', $topic
    ),
    op_truncate($topic->getCommunity()->getName(), 28)
  );
}
$options = array(
  'border' => true,
);
op_include_list('communityList', $list, $options);
?>

<?php if ($pager->haveToPaginate()): ?>
<?php op_include_pager_navigation($pager, '@communityTopic_recently_topic_list?page=%d', array('is_total' => false)) ?>
<?php endif; ?>

<?php endif; ?>
