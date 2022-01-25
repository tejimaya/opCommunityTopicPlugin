<?php
use_helper('opAsset');
op_smt_use_stylesheet('/opCommunityTopicPlugin/css/smt-event.css', 'last');
?>

<?php
$options = array();
$options['title'] = __('Edit the event');
$options['url'] = url_for('communityEvent_update', $communityEvent);
?>

<div class="gadget_header">
  <?php echo __($options['title']) ?>
</div>

<div class="row">
  <div class="span12">
    <div class="help">
      <?php echo __('%0% is required field.', array('%0%' => '<strong>*</strong>')) ?>
    </div>
    <form method="post" action="<?php echo $options['url'] ?>" enctype="multipart/form-data">
      <?php echo $form['_csrf_token']->render() ?>
      <div class="span12 error">
        <?php echo $form->renderGlobalErrors() ?>
      </div>

      <!-- タイトル -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['name']->renderLabel().' <strong>*</strong>' ?>
        </div>
        <div class="error">
          <?php echo $form['name']->renderError() ?>
        </div>
        <div class="parts-body">
          <?php echo $form['name']->render() ?>
        </div>
      </div>

      <!-- 本文 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['body']->renderLabel().' <strong>*</strong>' ?>
        </div>
        <div class="error">
          <?php echo $form['body']->renderError() ?>
        </div>
        <div class="parts-body">
          <?php echo $form['body']->render() ?>
        </div>
      </div>

      <!-- 開催日時 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['open_date']->renderLabel().' <strong>*</strong>' ?>
        </div>
        <div class="error">
          <?php echo $form['open_date']->renderError() ?>
        </div>
        <div class="parts-body parts-date">
          <?php echo $form['open_date']->render() ?>
        </div>
      </div>

      <!-- 開催日時補足 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['open_date_comment']->renderLabel() ?>
        </div>
        <div class="error">
          <?php echo $form['open_date_comment']->renderError() ?>
        </div>
        <div class="parts-body">
          <?php echo $form['open_date_comment']->render() ?>
        </div>
      </div>

      <!-- 開催場所 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['area']->renderLabel().' <strong>*</strong>' ?>
        </div>
        <div class="error">
          <?php echo $form['area']->renderError() ?>
        </div>
        <div class="parts-body">
          <?php echo $form['area']->render() ?>
        </div>
      </div>

      <!-- 募集期日 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['application_deadline']->renderLabel() ?>
        </div>
        <div class="error">
          <?php echo $form['application_deadline']->renderError() ?>
        </div>
        <div class="parts-body parts-date">
          <?php echo $form['application_deadline']->render() ?>
        </div>
      </div>

      <!-- 募集人数 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['capacity']->renderLabel() ?>
        </div>
        <div class="error">
          <?php echo $form['capacity']->renderError() ?>
        </div>
        <div class="parts-body">
          <?php echo $form['capacity']->render() ?>
        </div>
      </div>

      <!-- 写真1 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['photo_1']->renderLabel() ?>
        </div>
        <div class="error">
          <?php echo $form['photo_1']->renderError() ?>
        </div>
        <div class="parts-body parts-photo">
          <?php echo $form['photo_1']->render() ?>
        </div>
      </div>

      <!-- 写真2 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['photo_2']->renderLabel() ?>
        </div>
        <div class="error">
          <?php echo $form['photo_2']->renderError() ?>
        </div>
        <div class="parts-body parts-photo">
          <?php echo $form['photo_2']->render() ?>
        </div>
      </div>

      <!-- 写真3 -->
      <div class="">
        <div class="parts-label">
          <?php echo $form['photo_3']->renderLabel() ?>
        </div>
        <div class="error">
          <?php echo $form['photo_3']->renderError() ?>
        </div>
        <div class="parts-body parts-photo">
          <?php echo $form['photo_3']->render() ?>
        </div>
      </div>

      <div class="center parts-button">
        <input type="submit" name="submit" value="<?php echo __('Post') ?>" class="btn btn-primary span12" />
      </div>

    </form>
  </div>
</div>
