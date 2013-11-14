<script id="<?php echo $target ?>Comment" type="text/x-jquery-tmpl">
  <div class="row" id="comment${id}">
    <div class="span11 comment-wrapper">
      <div class="comment-member-image">
        <a href="${member.profile_url}"><img src="${member.profile_image}" alt="{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}" width="23" /></a>
      </div>
      <div class="comment-content">
        <div class="comment-name-and-body">
        <a href="${member.profile_url}">{{if member.screen_name}} ${member.screen_name} {{else}} ${member.name} {{/if}}</a>
        <span class="comment-body">
          {{html body}}
        </span>
        </div>
        {{if images}}
          <div class="row">
            <div class="span11 images center">
              {{each images}}
                <div class="span2"><a href="${$value.filename}" target="_blank">{{html $value.imagetag}}</a></div>
              {{/each}}
            </div>
          </div>
        {{/if}}
      </div>
      <div class="comment-control row">
        <span>${$item.calcTimeAgo()}</span>
        {{if deletable}}
          <a href="javascript:void(0);" class="deleteComment" data-comment-id="${id}"><i class="icon-remove"></i></a>
        {{/if}}
      </div>
    </div>
  </div>
</script>
