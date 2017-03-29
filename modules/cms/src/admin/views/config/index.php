<?php
use luya\cms\admin\Module;

?>
<div class="card" ng-controller="ConfigController">
    <div style="padding:20px;">
        <h1><?= Module::t('menu_group_item_env_config'); ?></h1>
        <table class="striped">
            <tr>
                <td><?= Module::t('config_index_httpexceptionnavid'); ?></td>
                <td><menu-dropdown class="menu-dropdown" nav-id="data.httpExceptionNavId" /></td>
            </tr>
        </table>
        <a ng-click="save()" class="btn btn-priamry"><?= Module::t('view_update_btn_save'); ?></a>
    </div>
</div>