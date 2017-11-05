<?php

namespace luya\admin\dashboard;

/**
 * LIst Dashboard Object.
 *
 * The list dashboard object does already wrap the <ul class="list-group list-group-flush"> tag
 *
 * Example usage:
 *
 * ```php
 * [
 *     'class' => 'luya\admin\dashboards\ListObject',
 *     'template' => '<li class="list-group-item" ng-repeat="item in data">{{item.user.firstname}} {{item.user.lastname}}<span class="badge badge-info float-right">{{item.maxdate * 1000 | date:\'short\'}}</span></li>',
 *     'dataApiUrl' => 'admin/api-admin-common/last-logins',
 *     'title' => ['admin', 'dashboard_lastlogin_title'],
 * ],
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ListDashboardObject extends BasicDashboardObject
{
    /**
     * @inheritdoc
     */
    public $outerTemplate = '<div class="card-header">{{title}}</div><ul class="list-group list-group-flush">{{template}}</ul>';
}
