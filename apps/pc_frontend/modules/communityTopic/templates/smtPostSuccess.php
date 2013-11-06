<?php
if ($topic)
{
  $title = __('Edit the topic');
  $topicId    = $topic->getId();
  $topicName = $topic->getName();
  $topicBody  = $topic->getBody();
}
else
{
  $title = __('Create a new topic');
  $topicId    = '';
  $topicName = '';
  $topicBody  = '';
}
use_helper('opAsset');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-topic.css', 'last');
?>

<script type="text/javascript">
function getParams()
{
  var query = $('form').serializeArray(),
  json = {apiKey: openpne.apiKey};

  for (i in query)
  {
    json[query[i].name] = query[i].value
  }

  return json;
}

function toggleSubmitState()
{
  $('#loading').toggle();
  $('input[name=submit]').toggle();
}

function execute()
{
  toggleSubmitState();
  var params = getParams();

  $.ajax({
    url: openpne.apiBase + 'topic/post.json',
    type: 'POST',
    data: params,
    dataType: 'json',
    success: function(res) {
        if (params['id'] == '')
        {
          $('#id').val('');
          $('#topic_name').val('');
          $('#topic_body').val('');
        }

        window.location.href = window.location.origin + '/communityTopic/' + res.data.id
      },
    error: function(res) {
        if (res.responseText.match('name parameter is not specified.'))
        {
          alert('タイトルが空欄です。');
        }
        else if (res.responseText.match('body parameter is not specified.'))
        {
          alert('本文が空欄です。');
        }
        else
        {
          alert('トピック作成に失敗しました。');
          console.log(res)
        }

        toggleSubmitState();
      },
  });
}

$(function(){
  $("#post_topic").click(execute);
})
</script>

<div class="row">
  <div class="gadget_header span12"><?php echo __($title) ?></div>
</div>

<div class="row">
  <div class="span12">
    <form>
    <input type="hidden" name="id" id="id" value="<?php echo $topicId ?>"/>
    <input type="hidden" name="community_id" id="community_id" value="<?php echo $communityId ?>"/>
    <label class="control-label span12"><?php echo __('Title') ?></label>
    <input type="text" name="name" id="topic_name" class="span12" value="<?php echo $topicName ?>">
    <label class="control-label span12"><?php echo __('Body') ?></label>
    <textarea name="body" id="topic_body" class="span12" rows="10"><?php echo $topicBody ?></textarea>
    </form>
    <div class="center">
      <input type="submit" name="submit" value="<?php echo __('Post') ?>" id="post_topic" class="btn btn-primary span12" />
    </div>
  </div>
  <hr class="toumei">
  <div id="loading" class="center hide">
    <?php echo op_image_tag('ajax-loader.gif');?>
  </div>
</div>
