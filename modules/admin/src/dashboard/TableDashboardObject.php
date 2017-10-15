<?php

namespace luya\admin\dashboard;

/**
 * Table Dashboard Object.
 *
 * The table dashboard object does already wrap the table tag.
 *
 * Example usage:
 *
 * ```php
 * [
 *     'class' => 'luya\admin\dashboards\TableObject',
 *     'template' => '<thead><tr><th>Page</th><th>User</th><th>Time</ht></tr></thead><tr ng-repeat="item in data"><td><a ui-sref="custom.cmsedit({ navId : item.nav_id, templateId: \'cmsadmin/default/index\'})">{{item.title}}</a></td><td>{{item.updateUser.firstname}} {{item.updateUser.lastname}}</td><td>{{item.timestamp_update * 1000 | date:\'short\'}}</td></tr>',
 *     'dataApiUrl' => 'admin/api-cms-navitem/last-updates',
 *     'title' => ['cmsadmin', 'cmsadmin_dashboard_lastupdate'],
 * ],
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TableDashboardObject extends BasicDashboardObject
{
    /**
     * @inheritdoc
     */
    public $outerTemplate = '<div class="card-header">{{title}}</div><div class="card-body"><div class="table-responsive-wrapper"><table class="table table-hover">{{template}}</table></div></div>';
}
