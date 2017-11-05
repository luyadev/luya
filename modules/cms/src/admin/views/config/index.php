<?php
use luya\cms\admin\Module;

?>
<h1><?= Module::t('menu_group_item_env_config'); ?></h1>
<div class="card" ng-controller="ConfigController">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <td valign="top"><?= Module::t('config_index_httpexceptionnavid'); ?></td>
                <td><menu-dropdown class="menu-dropdown" nav-id="data.httpExceptionNavId" /></td>
            </tr>
        </table>
        <button type="button" ng-click="save()" class="btn btn-icon btn-save"><?= Module::t('btn_save'); ?></button>
    </div>
</div>