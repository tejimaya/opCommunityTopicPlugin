<?php slot('op_top') ?>
<div id="searchLine_1" class="parts searchFormLine">
  <form action="<?php echo url_for('communityTopic/searchForm')?>">
    <ul>
      <li><img alt="search" src="/web/images/icon_search.gif" /></li>
      <li>
        <input type="text" class="input_text" size="30" value="" name="keyword" />
      </li>
      <li>
        <select name="search_module">
          <option value="topic"><?php echo $topicSearchCaption ?></option>
          <option value="event"><?php echo $eventSearchCaption ?></option>
        </select>
      </li>
      <li>
        <input type="submit" class="input_submit" value="検索" />
      </li>
    </ul>
  </form>
</div>
<?php end_slot() ?>
