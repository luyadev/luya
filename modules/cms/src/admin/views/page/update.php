<?php
use luya\cms\admin\Module;
?>
<div class="cmsadmin" ng-controller="NavController" ng-show="!isDeleted" ng-init="settingsOverlay=true">
	<?= $this->render('_settings'); ?>
    <div class="row">
        <div class="col cmsadmin-frame-wrapper" ng-if="displayLiveContainer">
            <iframe class="cmsadmin-frame" ng-src="{{ liveUrl | trustAsResourceUrl:liveUrl }}" frameborder="0" width="100%" height="100%"></iframe>
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <div class="cmsadmin-toolbar">
                        <div class="toolbar-item" tooltip tooltip-text="<?= Module::t('view_update_hidden_info')?>" tooltip-position="bottom">
                            <label class="switch" for="switch-visibility-status">
                            	<span class="switch-label">
                                    <i class="material-icons" ng-show="!navData.is_hidden">visibility</i>
                                    <i class="material-icons" ng-show="navData.is_hidden">visibility_off</i>
                                </span>
                                <span class="switch-switch">
                                    <input class="switch-checkbox" ng-model="navData.is_hidden" ng-true-value="0" ng-false-value="1" type="checkbox" id="switch-visibility-status"/>
                                    <span class="switch-control"></span>
                                </span>
                            </label>
                        </div>
                        <div class="toolbar-item" tooltip tooltip-text="<?= Module::t('view_update_offline_info')?>" tooltip-position="bottom">
                            <label class="switch" for="switch-online-status">
                                <span class="switch-label">
                                    <i class="material-icons" ng-show="!navData.is_offline">cloud_queue</i>
                                    <i class="material-icons" ng-show="navData.is_offline">cloud_off</i>
                                </span>
                                <span class="switch-switch">
                                    <input class="switch-checkbox" type="checkbox" id="switch-online-status" ng-model="navData.is_offline" ng-true-value="0" ng-false-value="1"/>
                                    <span class="switch-control"></span>
                                </span>
                            </label>
                        </div>
                        <div class="toolbar-item toolbar-item-lang" ng-class="{'ml-auto':$first}" ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)" ng-show="AdminLangService.data.length > 1">
                            <button class="toolbar-button toolbar-button-flag" ng-class="{'active' : AdminLangService.isInSelection(lang.short_code)}" >
                                <span class="flag flag-{{lang.short_code}}">
                                    <span class="flag-fallback">{{lang.name}}</span>
                                </span>
                            </button>
                        </div>
                        <div class="toolbar-item" ng-click="settingsOverlay=!settingsOverlay" ng-class="{'ml-auto': AdminLangService.data.length <= 1}">
                            <button class="toolbar-button">
                                <i class="material-icons">more_vert</i>
                            </button>
                        </div>
                    </div>
                    <div class="cmsadmin-pages">
                        <div class="row">
                            <div class="col" ng-repeat="lang in languagesData" ng-if="AdminLangService.isInSelection(lang.short_code)" ng-controller="NavItemController">
                                <?= $this->render('_navitem'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col blockholder-column" ng-controller="DroppableBlocksController">
                    <div class="blockholder">
                        <div class="blockholder-search">
                            <input class="blockholder-search-input" id="blockholder-search" ng-model="searchQuery" />
                            <label class="blockholder-search-label" for="blockholder-search">
                                <i class="material-icons">search</i>
                            </label>
                        </div>
                        <div class="blockholder-group blockholder-group-copy-stack" ng-show="copyStack.length > 0">
                            <span class="blockholder-group-title">
                                <i class="material-icons">bookmark</i>
                                <span>
                                    <?= Module::t('view_update_blockholder_clipboard') ?>
                                    <a class="blockholder-clear-button" ng-click="clearStack()"><i class="material-icons">clear</i></a>
                                </span>
                            </span>
                            <ul class="blockholder-list">
                                <li class="blockholder-item"
                                    ng-repeat="stackItem in copyStack"
                                    dnd dnd-model="stackItem"
                                    dnd-isvalid="true"
                                    dnd-drop-disabled
                                    dnd-css="{onDrag: 'drag-start', onHover: 'red', onHoverTop: 'red-top', onHoverMiddle: 'red-middle', onHoverBottom: 'red-bottom'}"
                                >
                                    <i class="material-icons blockholder-icon">{{stackItem.icon}}</i>
                                    <span>{{stackItem.name}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="blockholder-group" ng-class="{'blockholder-group-favorites': item.group.is_fav, 'blockholder-group-toggled': !item.group.toggle_open}" ng-repeat="item in blocksData | orderBy:'groupPosition'" >
                            <span class="blockholder-group-title" ng-click="toggleGroup(item.group)" ng-hide="searchQuery.length > 0">
                                <i class="material-icons" ng-if="item.group.is_fav">favorite</i>
                                <i class="material-icons blockholder-toggle-icon" ng-if="!item.group.is_fav">keyboard_arrow_down</i>
                                <span>{{item.group.name}}</span>
                            </span>
                            <ul class="blockholder-list">
                                <li class="blockholder-item" ng-show="item.group.toggle_open" ng-repeat="block in item.blocks | orderBy:'name' | filter:{name:searchQuery}"
                                    dnd dnd-model="block" dnd-isvalid="true" dnd-drop-disabled dnd-css="{onDrag: 'drag-start', onHover: 'red', onHoverTop: 'red-top', onHoverMiddle: 'red-middle', onHoverBottom: 'red-bottom'}"
                                >
                                    <i class="material-icons blockholder-icon">{{block.icon}}</i>
                                    <span>{{block.name}}</span>
                                    <button class="blockholder-favorite" ng-click="addToFav(block)" ng-if="!item.group.is_fav && !block.favorized">
                                        <i class="material-icons">favorite</i>
                                    </button>
                                    <button class="blockholder-favorite blockholder-favorite-clear" ng-click="removeFromFav(block)" ng-if="item.group.is_fav">
                                        <i class="material-icons">clear</i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>