<div class="page-header">
    <h2><?= t('Generate Demo Data') ?></h2>
</div>

<form action="<?= $this->url->href('demodata', 'import', array('plugin' => 'demodata')) ?>" method="post" enctype="multipart/form-data" class="listing">
  <?= $this->form->csrf() ?>
<!--  <label><?= t('Generate Demo Data') ?></label>
  <input type="file" name="wunderlist_file" accept="application/json" /> -->
  <div class="form-help"><?= t('Warning all current data will be trashed execpt the admin account!') ?></div>
  <div class="form-actions">
    <input type="submit" value="<?= t('Generate') ?>" class="btn btn-blue"/>
  </div>
</form>
