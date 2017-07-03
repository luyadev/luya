<?php
use luya\cms\admin\Module;
?>
<modal is-modal-hidden="itemSettingsOverlay" title="{{item.title}} Settings">
<div class="row"  ng-init="tab=1">
    <div class="col-md-3">
        <ul class="nav nav-pills flex-column">
            <li class="nav-item">
                <a class="nav-link" ng-click="tab=1" ng-class="{'active':tab==1}">Title &amp; Slug</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" ng-click="tab=3" ng-class="{'active':tab==3}">Versions</a>
            </li>
        </ul>
    </div>
    <div class="col-md-9" ng-switch="tab">
        <div ng-switch-when="1">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="input input--text col s12">
                    <label class="input__label"><?= Module::t('view_index_page_title'); ?></label>
                    <div class="input__field-wrapper">
                        <input type="text" class="input__field validate" ng-model="itemCopy.title" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input input--text col s12">
                    <label class="input__label"><?= Module::t('view_index_page_alias'); ?></label>
                    <div class="input__field-wrapper">
                        <input type="text" class="input__field validate" ng-model="itemCopy.alias" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input input--text col s12">
                    <label class="input__label"><?= Module::t('model_navitem_title_tag_label'); ?></label>
                    <div class="input__field-wrapper">
                        <input type="text" class="input__field validate" ng-model="itemCopy.title_tag" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input input--text col s12">
                    <label class="input__label"><?= Module::t('view_index_page_meta_description'); ?></label>
                    <div class="input__field-wrapper">
                        <textarea class="input__field validate" ng-model="itemCopy.description"></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="input input--text col s12">
                    <label class="input__label"><?= Module::t('view_index_page_meta_keywords'); ?></label>
                    <div class="input__field-wrapper">
                        <textarea class="input__field validate" ng-model="itemCopy.keywords"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div ng-switch-when="2">
            <h1>Dashboard</h1>
        </div>
        <div ng-switch-when="3">
            <h1>Dashboard</h1>
        </div>
    </div>
</div>
</modal>