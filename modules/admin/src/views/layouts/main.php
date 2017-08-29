<?php
use luya\admin\Module as Admin;
use luya\helpers\Url;

$user = Yii::$app->adminuser->getIdentity();
$this->beginPage()
?><!DOCTYPE html>
<html ng-app="zaa" ng-controller="LayoutMenuController">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?= Yii::$app->siteTitle; ?> &rsaquo; {{currentItem.alias}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?= Url::base(true); ?>/admin" />
    <style type="text/css">
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
  			display: none !important;
		}
		.dragover {
		    border: 5px dashed #2196F3;
		}
    </style>
    <?php $this->head(); ?>
</head>
<body ng-cloak flow-prevent-drop class="{{browser}} {{AdminClassService.getClassSpace('modalBody')}}">
<?php $this->beginBody(); ?>
<?= $this->render('_angulardirectives'); ?>
<div class="luya">
    <div class="luya-mainnav" ng-class="{'luya-mainnav-small' : !isHover}">
        <div class="mainnav" ng-class="{'mainnav-small' : !isHover}">
            <div class="mainnav-toggler-mobile">
                <div class="mainnav-toggler-mobile-icon" ng-click="isOpen = !isOpen">
                    <div class="mainnav-mobile-title">{{currentItem.alias}}</div>
                    <i class="material-icons" ng-show="!isOpen">menu</i>
                    <i class="material-icons" ng-show="isOpen">close</i>
                </div>
            </div>

            <div class="mainnav-static" ng-class="{'mainnav-hidden': !isOpen}">
                <ul class="mainnav-list">
                    <li class="mainnav-entry hide-on-mobile" tooltip tooltip-text="Search" tooltip-position="right" tooltip-disabled="isHover">
                        <span class="mainnav-link" ng-click="toggleSearchInput()" ng-class="{'mainnav-link-active' : searchInputOpen }">
                            <i class="mainnav-icon material-icons">search</i>
                            <span class="mainnav-label">
                                Search
                            </span>
                        </span>
                    </li>
                    <li class="mainnav-entry" tooltip tooltip-text="Dashboard" tooltip-position="right" tooltip-disabled="isHover">
                        <span class="mainnav-link" ui-sref="home" ui-sref-active="mainnav-link-active">
                            <i class="mainnav-icon material-icons">home</i>
                            <span class="mainnav-label">
                                Dashboard
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="mainnav-modules" ng-class="{'mainnav-hidden': !isOpen}">
                <ul class="mainnav-list">
                    <li class="mainnav-entry" ng-repeat="item in items" tooltip tooltip-text="{{item.alias}}" tooltip-position="right" tooltip-disabled="isHover">
                        <span class="mainnav-link" ng-class="{'mainnav-link-active' : isActive(item) }" ng-click="click(item)">
                            <i class="mainnav-icon material-icons">{{item.icon}}</i>
                            <span class="mainnav-label">
                                {{item.alias}}
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="mainnav-static mainnav-static--bottom" ng-class="{'mainnav-hidden': !isOpen}">
                <ul class="mainnav-list">
                    <li class="mainnav-entry" tooltip tooltip-text="<?= Admin::t('layout_btn_reload'); ?>" tooltip-position="right" tooltip-disabled="isHover">
                        <span class="mainnav-link" ng-click="reload()">
                            <i class="mainnav-icon material-icons">refresh</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_reload'); ?>
                            </span>
                        </span>
                    </li>
                    <li class="mainnav-entry hide-on-mobile">
                        <span class="mainnav-link">
                            <div class="mainnav-icon mainnav-icon-user-count">
                                <span class="mainnav-user-online">{{notify.length}}</span>
                                <i class="material-icons">panorama_fish_eye</i>
                            </div>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_useronline'); ?>
                            </span>
                            <span class="mainnav-tooltip-big">
                               <table>
                                  <tr>
                                    <th><?= Admin::t('layout_useronline_name'); ?></th>
                                    <th><?= Admin::t('layout_useronline_mail'); ?></th>
                                    <th><?= Admin::t('layout_useronline_activity'); ?></th>
                                  </tr>
                                  <tr ng-repeat="row in notify" ng-class="{ 'mainnav-tooltip-big-green' : row.is_active, 'mainnav-tooltip-big-gray' : !row.is_active }">
                                    <td>{{row.firstname}} {{row.lastname}}</td>
                                    <td>{{row.email}}</td>
                                    <td class="tooltip-big-activity">
                                        <span ng-show="!row.is_active">
                                            <span><b>{{row.inactive_since}}</b>&nbsp;<?= Admin::t('layout_useronline_inactive'); ?></span><br />
                                            <small>{{ row.lock_description }}</small>
                                        </span>
                                        <small ng-show="row.is_active">{{ row.lock_description }}</small>
                                    </td>
                                  </tr>
                                </table>
                            </span>
                        </span>
                    </li>
                    <li class="mainnav-entry" tooltip tooltip-text="<?= Admin::t('layout_btn_profile'); ?>" tooltip-position="right" tooltip-disabled="isHover">
                        <a class="mainnav-link" ui-sref="custom({templateId:'admin/account/dashboard'})">
                            <i class="mainnav-icon material-icons">account_circle</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_profile'); ?>
                            </span>
                        </a>
                    </li>
                    <li class="mainnav-entry" ng-show="settings.isDeveloper">
                        <a class="mainnav-link" ng-click="showDebugBar=!showDebugBar">
                            <span class="mainnav-icon">
                                <img class="mainnav-image-icon" src="<?= $this->getAssetUrl('luya\admin\assets\Main'); ?>/images/luya-logo-small.png" />
                            </span>
                            <span class="mainnav-label">
                                LUYA
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <button class="mainnav-toggler" ng-class="{'mainnav-toggler-open' : isHover}" ng-click="isHover = !isHover">
                <i class="material-icons">chevron_right</i>
            </button>
        </div>
    </div>

    <div ui-view class="luya-main-wrapper"></div>

    <div class="luyasearch" ng-class="{'luyasearch-open' : searchInputOpen, 'luyasearch-closed': !searchInputOpen, 'luyasearch-toggled': isHover}" zaa-esc="escapeSearchInput()">
        <div class="luyasearch-inner">
            <div class="luyasearch-form form-group">
                <input id="global-search-input" ng-model="searchQuery" type="search" class="luyasearch-input form-control" placeholder="<?= Admin::t('layout_filemanager_search_text'); ?>"/>
                <div class="luyasearch-close">
                    <i class="material-icons luyasearch-close-icon" ng-click="closeSearchInput()">close</i>
                </div>
            </div>
            <div class="alert alert-info" ng-show="searchResponse==null && searchQuery.length <= 2 && searchQuery.length > 0">
                <?= Admin::t('layout_search_min_letters'); ?>
            </div>
            <div class="alert alert-info" ng-show="(searchResponse.length == 0 && searchResponse != null) && searchQuery.length > 2">
                <?= Admin::t('layout_search_no_results'); ?>
            </div>
            <div class="alert" ng-show="searchResponse==null && searchQuery.length > 2">
                Loading ...
            </div>
            <div class="luyasearch-results">
                <div class="luyasearch-result" ng-repeat="item in searchResponse">
                    <div class="luyasearch-result-title"><i class="material-icons">{{item.menuItem.icon}}</i>&nbsp;<span>{{item.menuItem.alias}}</span>
                        <i class="material-icons luyasearch-toggler luyasearch-toggler-open">chevron_right</i>  <!-- toggle class "luyasearch-toggler-open" and "luyasearch-toggler-close" -->
                    </div>
                    <div class="luyasearch-table-wrapper">
                        <table class="luyasearch-table">
                            <tr ng-repeat="row in item.data | limitTo:1">
                                <th ng-hide="!item.hideFields.indexOf(k)" ng-repeat="(k,v) in row">{{k}}</th>
                            </tr>
                            <tr ng-repeat="row in item.data" ng-click="searchDetailClick(item, row)">
                                <td ng-hide="!item.hideFields.indexOf(k)" ng-repeat="(k,v) in row">{{v}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="debug" ng-show="showDebugBar" ng-class="{'debug-toggled': isHover}">
        <button type="button" class="close" ng-click="showDebugBar=!showDebugBar" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="debug-inner">
            <div class="debug-items" ng-show="debugItem" ng-hide="debugDetail">
                <ul class="debug-item" ng-repeat="(key, item) in AdminDebugBar.data" ng-class="{'table-primary': key == debugDetailKey}">
                    <li>URL: {{ item.url }}

                    </li>
                    <li>Status: {{ item.responseStatus }}</li>
                    <li>Time: {{ item.parseTime }}ms</li>
                    <li>
                        <button class="btn btn-primary" type="button" ng-click="loadDebugDetail(item, key)">Details</button>
                    </li>
                </ul>
            </div>
            <div class="debug-details">
                <ul class="debug-detail" ng-show="debugDetail">
                    <li>Request URL: {{debugDetail.url}}</li>
                    <li>Parse Time: {{debugDetail.parseTime}}</li>
                    <li>Request Data: {{debugDetail.requestData}}</li>
                    <li>Response Status: {{debugDetail.responseStatus}}</li>
                    <li>ResponseData: {{debugDetail.responseData}}</li>
                    <li>
                        <button class="btn btn-primary" type="button" ng-click="debugItem=!debugItem; debugDetail=!debugDetail">Hide Details</button>
                    </li>
                </ul>
            </div>
        </div>
    </div> <!-- end of debug inner -->
</div>
<div class="toasts" ng-repeat="item in toastQueue">
    <div class="modal fade show" tabindex="-1" role="dialog" aria-hidden="true" ng-if="item.type == 'confirm'" zaa-esc="item.close()" style="display: block;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{item.title}}</h5>
                    <button type="button" class="close" ng-click="item.close()" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{item.message}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" ng-click="item.close()"><?= Admin::t('button_abort'); ?></button>
                    <button type="button" class="btn btn-primary" ng-click="item.click()"><?= Admin::t('button_confirm'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div class="toasts-toast" ng-if="item.type != 'confirm'" style="transform: translateY(-{{ ($index * 100) }}%);">
        <div class="alert" ng-class="{'alert-success': item.type == 'success', 'alert-danger': item.type == 'error', 'alert-warning': item.type == 'warning', 'alert-info': item.type == 'info'}">
            <i class="material-icons" ng-show="item.type == 'success'">check_circle</i>
            <i class="material-icons" ng-show="item.type == 'error'">error_outline</i>
            <i class="material-icons" ng-show="item.type == 'warning'">warning</i>
            <i class="material-icons" ng-show="item.type == 'info'">info_outline</i>
            <span>{{item.message}}</span>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>