<?php use_helper('Date') ?>
<?php
$list = array();
$getCommunityComment = 'event' === $type
  ? 'getCommunityEventComment'
  : 'getCommunityTopicComment';
foreach ($pager->getResults() as $communityTopic)
{
  $list[] = sprintf("%s<br>%s(%s)",
    op_format_date($communityTopic->getUpdatedAt(), 'XDateTime'),
    link_to(
      sprintf("%s(%d)",
        op_truncate($communityTopic->getName(), 28),
        $communityTopic->$getCommunityComment()->count()
      ),
      sprintf($link_to_detail, $communityTopic->getId()),
      $communityTopic
    ),
    op_truncate($communityTopic->getCommunity()->getName(), 17)
  );
}
op_include_list('communityTopic', $list, array('border' => true));
?>
