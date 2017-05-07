<div style="padding:50px; margin:50px; text-align:center; background-color:#F0F0F0;">
	<h1><?php echo \luya\admin\Module::t('dashboard_title'); ?></h1>
    <p><?php echo \luya\admin\Module::t('dashboard_text'); ?></p>
</div>

<div class="row">
<?php foreach ($items as $dashboard): /* @var $dashboard \luya\admin\base\DashboardObjectInterface */ ?>
<div class="col s4">
	<div class="card-panel">
		<h4><?= $dashboard->getTitle(); ?></h4>
		<?= $dashboard->getTemplate(); ?>
	</div>
</div>
<?php endforeach; ?>
</div>