<div class="row">
    <div class="col s12">
        <h5><?= \cmsadmin\Module::t('draft_title'); ?></h5>
        <p><?= \cmsadmin\Module::t('draft_text'); ?></p>
        <div class="card-panel" ng-controller="DraftsController">
            <table class="striped">
                <thead>
                <tr>
                    <th><?= \cmsadmin\Module::t('draft_column_id'); ?></th>
                    <th><?= \cmsadmin\Module::t('draft_column_title'); ?></th>
                    <th><?= \cmsadmin\Module::t('draft_column_action'); ?></th>
                </tr>
                </thead>
                <tr ng-repeat="item in menuData.drafts">
                    <td>{{item.id}}</td>
                    <td>{{item.title}}</td>
                    <td><button type="button" ng-click="go(item.id)" class="btn btn-flat"><?= \cmsadmin\Module::t('draft_edit_button'); ?></button>
                </tr>
            </table>
        </div>
    </div>
</div>