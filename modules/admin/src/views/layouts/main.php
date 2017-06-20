<?php
use luya\admin\Module as Admin;
use luya\helpers\Url;
use yii\helpers\Markdown;

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
<body ng-cloak flow-prevent-drop>
<?php $this->beginBody(); ?>
<?= $this->render('_angulardirectives'); ?>
<div class="luya">
    <div class="luya-mainnav">
        <div class="mainnav" ng-class="{'mainnav-small' : !isHover}">
            <div class="mainnav-static">
                <ul class="mainnav-list">
                    <li class="mainnav-entry" tooltip tooltip-text="Search" tooltip-offset-top="5" tooltip-position="right">
                        <span class="mainnav-link" href="#">
                            <i class="mainnav-icon material-icons">search</i>
                            <span class="mainnav-label">
                                Search
                            </span>
                        </span>
                    </li>
                    <li class="mainnav-entry" tooltip tooltip-text="Dashboard" tooltip-offset-top="5" tooltip-position="right">
                        <span class="mainnav-link" ui-sref="home" ui-sref-active="mainnav-link--active">
                            <i class="mainnav-icon material-icons">home</i>
                            <span class="mainnav-label">
                                Dashboard
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="mainnav-modules">
                <ul class="mainnav-list">
                    <li class="mainnav-entry" ng-repeat="item in items" tooltip tooltip-text="{{item.alias}}" tooltip-offset-top="5" tooltip-position="right">
                        <span class="mainnav-link" ng-class="{'mainnav-link--active' : isActive(item) }" ng-click="click(item)">
                            <i class="mainnav-icon material-icons">{{item.icon}}</i>
                            <span class="mainnav-label">
                                {{item.alias}}
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="mainnav-static mainnav-static--bottom">
                <ul class="mainnav-list">
                    <li class="mainnav-entry" tooltip tooltip-text="<?= Admin::t('layout_btn_reload'); ?>" tooltip-offset-top="5" tooltip-position="right">
                        <span class="mainnav-link" ng-click="reload()">
                            <i class="mainnav-icon material-icons">refresh</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_reload'); ?>
                            </span>
                        </span>
                    </li>
                    <!-- 
                    <li class="mainnav-entry">
                        <a class="mainnav-link" href="#">
                            <i class="mainnav-icon material-icons">developer_board</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_version'); ?>
                            </span>
                        </a>
                    </li>
                     -->
                    <li class="mainnav-entry" tooltip tooltip-text="<?= Admin::t('layout_btn_useronline'); ?>" tooltip-offset-top="5" tooltip-position="right">
                        <a class="mainnav-link" href="#">
                            <i class="mainnav-icon material-icons">panorama_fish_eye</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_useronline'); ?>
                            </span>
                        </a>
                    </li>
                    <!-- 
                    <li class="mainnav-entry">
                        <a class="mainnav-link" href="<?= Yii::$app->urlManager->createUrl(['admin/default/logout']); ?>">
                            <i class="mainnav-icon material-icons">exit_to_app</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_logout'); ?>
                            </span>
                        </a>
                    </li>
                    -->
                    <li class="mainnav-entry" tooltip tooltip-text="<?= Admin::t('layout_btn_profile'); ?>" tooltip-offset-top="5" tooltip-position="right">
                        <a class="mainnav-link" ui-sref="custom({templateId:'admin/account/dashboard'})">
                            <i class="mainnav-icon material-icons">account_circle</i>
                            <span class="mainnav-label">
                                <?= Admin::t('layout_btn_profile'); ?>
                            </span>
                        </a>
                    </li>
                    <!-- 
                    <li class="mainnav-entry">
                        <a class="mainnav-link" href="https://luya.io" target="_blank">
                            <span class="mainnav-icon">
                                <img class="mainnav-image-icon" src="<?= $this->getAssetUrl('luya\admin\assets\Main'); ?>/images/luya-logo-small.png" />
                            </span>
                            <span class="mainnav-label">
                                LUYA
                            </span>
                        </a>
                    </li>
                    -->
                </ul>
            </div>
        </div>
     </div>
    <div class="luya-main" ui-view />
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>