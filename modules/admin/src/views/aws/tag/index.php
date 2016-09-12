<?php
use luya\admin\Module;

?>
<div class="row">
    <div class="col s12">
        <h1><?= $this->context->alias; ?></h1>
    </div>
</div>

<div class="row" ng-controller="ActiveWindowTagController">
    <div class="col s12">
        <div class="row">

            <div class="card-panel col s12">
                <br />

                <div class="input input--text">
                    <label class="input__label" for="newTag"><?= Module::t('aws_tag_new')?>:</label>
                    <div class="input__field-wrapper">
                        <input id="newTag" maxlength="255" ng-model="newTagName" type="text" class="input__field" />
                    </div>
                </div>

                <br />
                <button type="button" ng-click="saveTag()" class="btn btn-flat right"><?= Module::t('aws_tag_add')?> <i class="material-icons right">check</i></button>
                <div style="clear: both;"></div>

                <br />
            </div>
        </div>

        <div class="row">
            <div class="col s12 card-panel">
                <br />

                <div class="input input--text">
                    <label class="input__label" for="searchString"><?= Module::t('aws_tag_search')?>:</label>
                    <div class="input__field-wrapper">
                        <input id="searchString" maxlength="255" ng-model="searchString" type="text" class="input__field" />
                    </div>
                </div>

                <br />

                <div class="input input--multiple-checkboxes">
                    <label class="input__label"><?= Module::t('aws_tag_list')?>:</label>
                    <div class="input__field-wrapper input--column">
                        <div ng-repeat="tag in tags | filter:searchString | orderBy:'name'" class="checkbox-column-fix">
                            <input type="checkbox" ng-model="relation[tag.id]" ng-checked="relation[tag.id] == 1" ng-true-value="1" ng-false-value="0">
                            <label ng-click="saveRelation(tag, relation[tag.id])">{{tag.name}}</label>
                        </div>
                    </div>
                </div>


                <br />
            </div>
        </div>
    </div>
</div>