<?php if ($this->user->isAdmin()): ?>
<li <?= $this->app->getRouterController() === 'demodata' && $this->app->getRouterAction() === 'import' ? 'class="active"' : '' ?>>
    <?= $this->url->link(t('Generate Demo Data'), 'demodata', 'import', array('plugin' => 'demodata')) ?>
</li>
<?php endif ?>
