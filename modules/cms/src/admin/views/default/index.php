<?php
use \luya\cms\admin\Module;

?>
<style>
<!-
.b-top { border-top:2px solid red; }
.b-bottom { border-bottom:2px solid red; }
.b-left { border-left:2px solid red; }
.b-hover { background-color:green; }
->
</style>
<?= $this->render('_angulardirectives'); ?>
<script type="text/ng-template" id="reverse2.html">
    <span class="treeview-label treeview-label-page" dnd dnd-model="data" dnd-ondrop="dropItem(dragged,dropped,position)" dnd-isvalid="validItem(hover,dragged)" dnd-css='{onDrag:"make-drag",onHover:"b-hover",onHoverTop:"b-top",onHoverMiddle:"b-left",onHoverBottom:"b-bottom"}'>
        <span class="treeview-icon treeview-icon-collapse" ng-show="(menuData.items | menuparentfilter:catitem.id:data.id).length"  ng-click="toggleItem(data)">
            <i class="material-icons">arrow_drop_down</i>
        </span>
        <span class="treeview-icon treeview-icon-right" ng-if="data.is_home==1">
            <i class="material-icons">home</i>
        </span>
        <span class="treeview-link" ng-click="go(data)" >
            <span class="google-chrome-font-offset-fix">{{data.title}}</span>
        </span>
    </span>
    <ul class="treeview-items">
        <li class="treeview-item" ng-class="{'treeview-item-isoffline' : data.is_offline, 'treeview-item-collapsed': !data.toggle_open, 'treeview-item-ishidden': data.is_hidden, 'treeview-item-has-children' : (menuData.items | menuparentfilter:catitem.id:data.id).length}" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:data.id" ng-include="'reverse2.html'" />
    </ul>
</script>
<div class="luya-subnav" ng-controller="CmsMenuTreeController" ng-class="{'overlaying': liveEditStateToggler}">
    <div class="cmsnav">
        <ul class="cmsnav-list cmsnav-list-buttons">
            <?php if (Yii::$app->adminuser->canRoute('cmsadmin/page/create')): ?>
            <li class="cmsnav-button" ui-sref="custom.cmsadd">
                <div class="btn btn-block text-left btn-success">
                    <span class="material-icons">add_box</span>
                    <span class="btn-icon-label"><?= Module::t('view_index_sidebar_new_page'); ?></span>
                </div>
            </li>
            <?php endif; ?>
            <?php if (Yii::$app->adminuser->canRoute('cmsadmin/page/drafts')): ?>
            <li class="cmsnav-button" ui-sref="custom.cmsdraft">
                <div class="btn btn-block text-left btn-info">
                    <span class="material-icons">receipt</span>
                    <span class="btn-icon-label"><?= Module::t('view_index_sidebar_drafts'); ?></span>
                </div>
            </li>
            <?php endif; ?>
        </ul>
        <ul class="cmsnav-list cmsnav-list-switches">
            <li class="cmsnav-switch">
                <label class="switch" for="switch-live-preview">
                    <span class="switch-switch">
                        <input class="switch-checkbox" type="checkbox" id="switch-live-preview" ng-model="liveEditStateToggler" ng-true-value="1" ng-false-value="0" />
                        <span class="switch-control" for="switch-live-preview"></span>
                    </span>
                    <span class="switch-label">
                        Live preview
                    </span>
                </label>
            </li>
        </ul>
        <ul class="cmsnav-list cmsnav-list-treeview treeview"> 
            <li class="treeview-container"  ng-repeat="catitem in menuData.containers" >
                <div class="treeview-label treeview-label-container">
                    <span class="treeview-icon treeview-icon-collapse">
                        <i class="material-icons">keyboard_arrow_down</i>
                    </span>
                    <span class="treeview-link"><span class="google-chrome-font-offset-fix">{{catitem.alias}}</span></span>
                </div>
                <ul class="treeview-items treeview-items-lvl1">
                    <li class="treeview-item treeview-item-lvl1" ng-class="{'treeview-item-isoffline' : data.is_offline, 'treeview-item-collapsed': !data.toggle_open, 'treeview-item-ishidden': data.is_hidden, 'treeview-item-has-children' : (menuData.items | menuparentfilter:catitem.id:data.id).length}" ng-repeat="data in menuData.items | menuparentfilter:catitem.id:0" ng-include="'reverse2.html'" />
                </ul>
            </li>
        </ul>
    </div>
</div>
<div class="luya-content luya-content-cmsadmin" ui-view />