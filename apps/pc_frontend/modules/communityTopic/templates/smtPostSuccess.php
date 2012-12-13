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
op_smt_use_stylesheet('/opDiaryPlugin/css/smt-topic.css', 'last');
?>

<script id="successMessageTemplate" type="text/x-jquery-tmpl">
    投稿しました<br/>
    <a href="<?php echo public_path('communityTopic'); ?>/${id}">トピックを見る</a>
</script>

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

$(function(){
  $("#post_topic").click(function()
  {
    $('#successMessage').html('');
    toggleSubmitState();
    var params = getParams();

    $.post(openpne.apiBase + "topic/post.json",
      params,
      'json'
    )
    .success(
      function(res)
      {
        if (params['id'] == '')
        {
          $('#id').val('');
          $('#topic_name').val('');
          $('#topic_body').val('');
        }
        var _mes = $('#successMessageTemplate').tmpl(res['data']);
        $('#successMessage').html(_mes);
      }
    )
    .error(
      function(res)
      {
        console.log(res);
      }
    )
    .complete(
      function(res)
      {
        toggleSubmitState();
      }
    );
  });
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
  <div id="successMessage" class="center">
  </div>
</div>
