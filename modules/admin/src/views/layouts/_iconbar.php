<?php
use luya\admin\Module as Admin;

?>
<li class="icon" ng-click="reload()" >
    <div class="navbar__button">
        <i class="material-icons">replay</i>
        <p class="icon__spawn-text"><?= Admin::t('layout_btn_reload'); ?></p>
    </div>
</li>
<li class="icon" ng-mouseenter="showDebugContainer=1" ng-mouseleave="showDebugContainer=0">
    <div class="navbar__button">
        <i class="material-icons">developer_board</i>
        <p class="icon__spawn-text"><?= Admin::t('layout_btn_version'); ?></p>
    </div>
</li>
<li class="icon" ng-mouseenter="showOnlineContainer=1" ng-mouseleave="showOnlineContainer=0">
    <div class="navbar__button">
        <i class="material-icons">panorama_fish_eye</i>
        <span class="useronline__number">{{notify.length}}</span>
        <p class="icon__spawn-text"><?= Admin::t('layout_btn_useronline'); ?></p>
    </div>
</li>
<li class="icon" ng-click="toggleHelpPanel()" >
    <div class="navbar__button">
        <i class="material-icons">help_outline</i>
        <p class="icon__spawn-text"><?= Admin::t('layout_btn_help'); ?></p>
    </div>
</li>
<li class="icon">
    <div class="navbar__button navbar__button--redhighlight">
        <a href="<?= Yii::$app->urlManager->createUrl(['admin/default/logout']); ?>" class="navbar__button__anchor">
            <i class="material-icons">exit_to_app</i>
        </a>
        <p class="icon__spawn-text"><?= Admin::t('layout_btn_logout'); ?></p>
    </div>
</li>
<li class="icon icon__username">
    <div class="navbar__button" ui-sref="custom({templateId:'admin/account/dashboard'})">
        <i class="material-icons left">account_circle</i><strong><?= Yii::$app->adminuser->identity->firstname; ?></strong>
        <p class="icon__spawn-text"><?= Admin::t('layout_btn_profile'); ?></p>
    </div>
</li>