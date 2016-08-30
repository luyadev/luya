<div class="row">
    <div class="col s12">
        <h5><?php echo \luya\cms\admin\Module::t('draft_title'); ?></h5>
        <p><?php echo \luya\cms\admin\Module::t('draft_text'); ?></p>
        <div class="card-panel" ng-controller="DraftsController">
            <table class="striped">
                <thead>
                <tr>
                    <th><?php echo \luya\cms\admin\Module::t('draft_column_id'); ?></th>
                    <th><?php echo \luya\cms\admin\Module::t('draft_column_title'); ?></th>
                    <th><?php echo \luya\cms\admin\Module::t('draft_column_action'); ?></th>
                </tr>
                </thead>
                <tr ng-repeat="item in menuData.drafts">
                    <td>{{item.id}}</td>
                    <td>{{item.title}}</td>
                    <td><button type="button" ng-click="go(item.id)" class="btn btn-flat"><?php echo \luya\cms\admin\Module::t('draft_edit_button'); ?></button>
                </tr>
            </table>
        </div>
    </div>
</div>