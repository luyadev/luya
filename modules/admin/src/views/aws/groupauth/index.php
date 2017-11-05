<?php
use luya\admin\Module;

?>
<div ng-controller="ActiveWindowGroupAuth">

    <div class="text-right mb-3">
        <button type="button" ng-click="toggleAll()" class="btn btn-secondary btn-icon"><i class="material-icons">done_all</i> <span><?= Module::t('aws_groupauth_select_all'); ?></span></button>
        <button type="button" ng-click="untoggleAll()" class="btn btn-secondary btn-icon"><i class="material-icons">clear_all</i> <span><?= Module::t('aws_groupauth_deselect_all'); ?></span></button>
    </div>

    <form id="updateSubscription">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><?= Module::t('aws_groupauth_th_module'); ?></th>
                    <th><?= Module::t('aws_groupauth_th_function'); ?></th>
                    <th><?= Module::t('aws_groupauth_th_add'); ?></th>
                    <th><?= Module::t('aws_groupauth_th_edit'); ?></th>
                    <th><?= Module::t('aws_groupauth_th_remove'); ?></th>
                </tr>
            </thead>
            <tr ng-repeat="a in auths">
                <td><b><span ng-show="a.is_head==1">{{ a.group_alias }}</span></b></td>
                <td><input id="{{a.id}}_base" type="checkbox" ng-model="rights[a.id].base" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_base">{{ a.alias_name}}</label></td>
                <td ng-show="a.is_crud==1"><input id="{{a.id}}_create" type="checkbox" ng-model="rights[a.id].create" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_create"></label></td>
                <td ng-show="a.is_crud==1"><input id="{{a.id}}_update" type="checkbox" ng-model="rights[a.id].update" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_update"></label></td>
                <td ng-show="a.is_crud==1"><input id="{{a.id}}_delete" type="checkbox" ng-model="rights[a.id].delete" ng-true-value="1" ng-false-value="0" /><label for="{{a.id}}_delete"></label></td>
            </tr>
        </table>
    </form>

    <div class="modal-footer">
        <button type="button" ng-click="save(rights)" class="btn btn-save btn-icon"><?= Module::t('button_save'); ?></button>
    </div>
</div>