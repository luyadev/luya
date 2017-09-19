<?php
use luya\admin\helpers\Angular;
use luya\admin\Module;

?>

<div ng-controller="ActiveWindowTagController">

    <div class="row">
        <div class="col">

            <div class="form-group mb-2">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="material-icons">add</i>
                    </div>
                    <input class="form-control" id="searchString" maxlength="255" ng-model="newTagName" type="text" />
                </div>
            </div>

            <button type="submit" class="btn btn-add btn-icon float-right" ng-click="saveTag()"><?= Module::t('aws_tag_add')?></button>

        </div>
    </div>

    <div class="row mt-4">
        <div class="col">

            <div class="input-group mb-3">
                <div class="input-group-addon">
                    <i class="material-icons">search</i>
                </div>
                <input class="form-control" type="text" ng-model="searchString" placeholder="Enter search term...">
            </div>
            <div class="form-check" ng-repeat="tag in tags | filter:searchString | orderBy: 'name'">
                <input id="id-{{tag.id}}" type="checkbox" class="form-check-input" ng-model="relation[tag.id]" ng-checked="relation[tag.id] == 1" ng-true-value="1" ng-false-value="0">
                <label for="id-{{tag.id}}" ng-click="saveRelation(tag, relation[tag.id])">{{tag.name}}</label>
            </div>

        </div>
    </div>

</div>