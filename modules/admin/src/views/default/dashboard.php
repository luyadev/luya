<div class="luya__content">
    <h1><?php echo \luya\admin\Module::t('dashboard_title'); ?></h1>
    <p><?php echo \luya\admin\Module::t('dashboard_text'); ?></p>
    <div class="row">
    <?php foreach ($items as $dashboard): /* @var $dashboard \luya\admin\base\DashboardObjectInterface */ ?>
    <div class="col-md-4">
    	<?= $dashboard->getTemplate(); ?>
    </div>
    <?php endforeach; ?>
    </div>
</div>