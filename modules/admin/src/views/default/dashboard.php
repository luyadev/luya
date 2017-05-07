<div style="padding:50px; margin:50px; text-align:center; background-color:#F0F0F0;">
	<h1><?php echo \luya\admin\Module::t('dashboard_title'); ?></h1>
    <p><?php echo \luya\admin\Module::t('dashboard_text'); ?></p>
</div>

<div style="margin:50px;">
<?php foreach ($items as $dashboard): /* @var $dashboard \luya\admin\base\DashboardObjectInterface */ ?>
<div class="col s4">
	<?= $dashboard->getTemplate(); ?>
</div>
<?php endforeach; ?>
</div>