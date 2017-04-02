<?php
use luya\admin\Module;

?>
<h3><?= $this->context->alias; ?></h3>
<div class="row" ng-controller="ActiveWindowTagController">
    <div class="col s9">
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
    <div class="col s3">
        <form ng-submit="saveTag()">
            <div class="input input--text input--vertical">
                <label class="input__label" for="newTag"><?= Module::t('aws_tag_new')?>:</label>
                <div class="input__field-wrapper">
                    <input id="newTag" maxlength="255" ng-model="newTagName" type="text" class="input__field" />
                </div>
            </div>
            <button type="submit" class="btn btn-default"><?= Module::t('aws_tag_add')?> <i class="material-icons right">check</i></button>
        </form>
    </div>
</div>