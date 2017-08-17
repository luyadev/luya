<?php
use luya\admin\Module;
?>
<div class="row" ng-controller="ActiveWindowTagController">
    <div class="col-md-9">
        <div class="input input--text input--vertical">
            <label class="input__label" for="searchString"><?= Module::t('aws_tag_search')?></label>
            <div class="input__field-wrapper">
                <input id="searchString" maxlength="255" ng-model="searchString" type="text" class="input__field" />
            </div>
        </div>
        <div class="input input--multiple-checkboxes input--vertical">
            <label class="input__label"><?= Module::t('aws_tag_list')?></label>
            <div class="input__field-wrapper input--column">
                <div ng-repeat="tag in tags | filter:searchString | orderBy:'name'" class="checkbox-column-fix">
                    <input type="checkbox" ng-model="relation[tag.id]" ng-checked="relation[tag.id] == 1" ng-true-value="1" ng-false-value="0">
                    <label ng-click="saveRelation(tag, relation[tag.id])">{{tag.name}}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <form ng-submit="saveTag()">
            <zaa-text model="newTagName" label="<?= Module::t('aws_tag_new')?>" />
            <button type="submit" class="btn btn-primary"><?= Module::t('aws_tag_add')?></button>
        </form>
    </div>
</div>