<div class="row" style="margin:15px 10px;">
    <div class="col s4">
        <div class="card-panel  orange lighten-2">
            <h1><?php echo \luya\admin\Module::t('dashboard_title'); ?></h1>
            <p><?php echo \luya\admin\Module::t('dashboard_text'); ?></p>
        </div>
    </div>
    <?php foreach ($items as $dashboard): /* @var $dashboard \luya\admin\base\DashboardObjectInterface */ ?>
    <div class="col s4">
    	<?= $dashboard->getTemplate(); ?>
    </div>
    <?php endforeach; ?>
</div>