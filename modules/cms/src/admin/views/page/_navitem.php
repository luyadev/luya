<?php
use luya\cms\admin\Module;
use luya\helpers\Html;

?>
<script type="text/ng-template" id="recursion.html">
<h4 class="cmsadmin-container-title">{{placeholder.label}}</h4>
<div class="card">
    <div class="card-body">
        <div class="empty-placeholder" ng-if="placeholder.__nav_item_page_block_items.length == 0" dnd dnd-drag-disabled dnd-model="placeholder" dnd-isvalid="true" dnd-ondrop="dropItemPlaceholder(dragged,dropped,position, element)" dnd-css="{onDrag: 'empty-placeholder--is-dragging', onHover: 'empty-placeholder--drag-hover', onHoverTop: 'empty-placeholder--drag-top', onHoverMiddle: 'empty-placeholder--drag-middle', onHoverBottom: 'empty-placeholder--drag-bottom'}"><?= Module::t('view_update_drop_blocks'); ?></div>
        <div ng-class="{'block-is-layout' : block.is_container}" ng-repeat="(key, block) in placeholder.__nav_item_page_block_items" ng-controller="PageBlockEditController">
            <div class="block" ng-class="{ 'block-is-hidden': block.is_hidden == 1, 'block-is-virgin' : !block.is_dirty && isEditable() && block.is_dirty_dialog_enabled && !block.is_container, 'block-is-container': block.is_container, 'block-first': $first, 'block-last': $last }" <?php if ($canBlockUpdate): ?>dnd dnd-model="block" dnd-isvalid="true" dnd-disable-drag-middle dnd-ondrop="dropItem(dragged,dropped,position,element)" dnd-css="{onDrag: 'block--is-dragging', onHover: 'block--drag-hover', onHoverTop: 'block--drag-top', onHoverMiddle: 'block--drag-middle', onHoverBottom: 'block--drag-bottom'}"<?php endif; ?>>
                <div class="block-toolbar">
                    <div class="toolbar-item">
                        <i class="material-icons">{{block.icon}}</i>
                        <span>{{block.name}}</span>
                    </div>
                    <div class="toolbar-item ml-auto" ng-click="copyBlock()">
                        <button class="block-toolbar-button" tooltip tooltip-text="<?= Html::encode(Module::t('view_update_block_tooltip_copy'));?>" tooltip-position="top">
                            <i class="material-icons">content_copy</i>
                        </button>
                    </div>
					<?php if ($canBlockUpdate): ?>
                    <div class="toolbar-item" ng-click="toggleHidden()" ng-show="block.is_hidden==0">
                        <button class="block-toolbar-button" tooltip tooltip-text="<?= Html::encode(Module::t('view_update_block_tooltip_visible'));?>" tooltip-position="top">
                            <i class="material-icons">visibility</i>
                        </button>
                    </div>
                    <div class="toolbar-item" ng-click="toggleHidden()" ng-show="block.is_hidden==1">
                        <button class="block-toolbar-button" tooltip tooltip-text="<?= Html::encode(Module::t('view_update_block_tooltip_invisible'));?>" tooltip-position="top">
                            <i class="material-icons">visibility_off</i>
                        </button>
                    </div>
					<?php endif; ?>
					<?php if ($canBlockDelete): ?>
                    <div class="toolbar-item" ng-click="removeBlock()">
                        <button class="block-toolbar-button" tooltip tooltip-text="<?= Html::encode(Module::t('view_update_block_tooltip_delete'));?>" tooltip-position="top">
                            <i class="material-icons">delete</i>
                        </button>
                    </div>
					<?php endif; ?>
					<?php if ($canBlockUpdate): ?>
                    <div ng-show="isEditable()" ng-click="toggleEdit()" class="toolbar-item">
                        <button class="block-toolbar-button" tooltip tooltip-text="<?= Html::encode(Module::t('view_update_block_tooltip_edit'));?>" tooltip-position="top">
                            <i class="material-icons">edit</i>
                        </button>
                    </div>
					<?php endif; ?>
                </div>
                <modal is-modal-hidden="modalHidden" modal-title="{{block.name}}">
                    <div ng-if="!modalHidden" class="card" ng-init="modalMode=1">
						<div class="card-header" ng-show="block.cfgs.length > 0">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item" ng-click="modalMode=1">
                                    <a class="nav-link" ng-class="{'active' : modalMode==1}" ng-click="modalMode=1"><?= Module::t('view_update_block_tooltip_edit'); ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" ng-class="{'active' : modalMode==2}" ng-click="modalMode=2"><?= Module::t('view_update_block_tooltip_editcfg'); ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                        <form class="block__edit" ng-submit="save()">
                            <div ng-if="modalMode==1" ng-repeat="field in block.vars" ng-hide="field.invisible" class="row">
                               <div class="col">
									<span ng-if="getInfo(field.var)" class="help-button btn btn-icon btn-help" tooltip tooltip-expression="getInfo(field.var)" tooltip-position="left"></span>
									<zaa-injector dir="field.type" options="field.options" fieldid="{{field.id}}" fieldname="{{field.var}}" initvalue="{{field.initvalue}}" placeholder="{{field.placeholder}}" label="{{field.label}}" model="data[field.var]"></zaa-injector>
								</div>
                            </div>
                            <div ng-if="modalMode==2"  ng-repeat="cfgField in block.cfgs" ng-hide="cfgField.invisible" class="row">
                                <div class="col">
									<span ng-if="getInfo(cfgField.var)" class="help-button btn btn-icon btn-help" tooltip tooltip-expression="getInfo(cfgField.var)" tooltip-position="left"></span>
                                   <zaa-injector dir="cfgField.type"  options="cfgField.options" fieldid="{{cfgField.id}}" fieldname="{{cfgField.var}}" initvalue="{{cfgField.initvalue}}"  placeholder="{{cfgField.placeholder}}" label="{{cfgField.label}}"  model="cfgdata[cfgField.var]"></zaa-injector>
                               </div>
                            </div>
                            <button type="submit" class="btn btn-save btn-icon"><?= Module::t('view_update_btn_save'); ?></button>
                            <button type="button" class="btn btn-icon btn-help float-right" ng-click="showHelp=!showHelp">{{ showHelp == true ? 'Hide help' : 'Show help' }}</button>
							<select ng-if="block.variations" class="btn float-right" ng-model="block.variation" style="margin-right:10px;">
                            	<option value="0" selected><?= Module::t('view_update_variation_select'); ?></option>
                                <option value="{{variationKey}}" ng-repeat="(variationKey, variation) in block.variations">{{variation.title}}</option>
                            </select>
                        </form>
                        </div>
						<div ng-if="showHelp">
							<ul class="help">
								<li click-paste-pusher="{{help.example}}"  ng-repeat="help in navCfg.helptags"><h3>{{help.name}}</h3><blockquote>{{help.example}}</blockquote><span ng-bind-html="help.readme | trustAsUnsafe"></span></li>
							</ul>
						</div>
                    </div>
                </modal>
                <div ng-if="!block.is_container" ng-click="toggleEdit()" class="block-front" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)"></div>
                <div ng-if="block.__placeholders.length" class="block-front">
                    <div class="row" ng-repeat="(inlineRowKey, row) in block.__placeholders">
                        <div class="col-xl-{{placeholder.cols}}" ng-repeat="(placeholderInlineKey, placeholder) in row track by placeholderInlineKey" ng-include="'recursion.html'"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<?= $this->render('_navitem_settings'); ?>
<div class="cmsadmin-nav-tabs" ng-if="loaded">
    <ul class="nav nav-tabs flex-no-wrap" role="tablist">
        <li class="nav-item nav-item-alternative nav-item-icon">
            <span class="flag flag-{{lang.short_code}}">
                <span class="flag-fallback">{{lang.name}}</span>
            </span>
        </li>
        <li class="nav-item nav-item-alternative nav-item-icon ml-auto" ng-show="isTranslated">
            <a class="nav-link" ng-click="toggleSettingsOverlay(1)">
                <i class="material-icons">edit</i>
            </a>
        </li>
        <?php if (Yii::$app->adminuser->canRoute(Module::ROUTE_PAGE_DELETE)): ?>
        <li class="nav-item nav-item-alternative nav-item-icon" ng-if="isTranslated && lang.is_default==0">
            <a ng-click="trashItem()" class="nav-link">
                <i class="material-icons">delete</i>
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item nav-item-alternative nav-item-icon" ng-show="isTranslated">
            <a ng-href="{{homeUrl}}preview/{{item.id}}?version={{currentPageVersion}}" target="_blank" class="nav-link" ng-show="!liveEditState">
                <i class="material-icons">open_in_new</i>
            </a>
            <a ng-click="openLiveUrl(item.id, currentPageVersion)" ng-show="liveEditState" class="nav-link">
                <i class="material-icons">open_in_new</i>
            </a>
        </li>
        <li class="nav item nav-item-title"><span>{{ item.title }}</span></li>
    </ul>

    <ul class="nav nav-tabs ml-auto" role="tablist" ng-if="item.nav_item_type==1 && !isDraft">
        <li class="nav-item dropdown" ng-class="{'show': versionDropDownVisbility}">
            <a class="nav-link dropdown-toggle" role="button" ng-click="toggleVersionsDropdown()">{{ currentPageVersionAlias }}</a>
            <div class="dropdown-menu dropdown-menu-right" ng-class="{'show': versionDropDownVisbility}">
                <div ng-repeat="versionItem in typeData">
                    <button type="button" class="dropdown-item" ng-class="{'active' : currentPageVersion == versionItem.id}" ng-click="switchVersion(versionItem.id)">
                        <span><span class="badge" ng-class="{'badge-secondary': item.nav_item_type_id!=versionItem.id, 'badge-primary': item.nav_item_type_id==versionItem.id}">V{{$index+1}}</span> {{ versionItem.version_alias }}</span>
                    </button>
                </div>
                <div class="dropdown-divider"></div>
                <span class="dropdown-item" ng-click="toggleSettingsOverlay(3); toggleVersionsDropdown()"><i class="material-icons">add_box</i> <span><?= Module::t('version_create_title'); ?></span></span>
            </div>
        </li>
    </ul>
</div>
<div ng-if="!loaded">loading...</div>
<div class="cmsadmin-page" ng-if="isTranslated && loaded">
    <div class="row" ng-if="item.nav_item_type==1" ng-repeat="(key, row) in container.__placeholders track by key">
        <div class="col-xl-{{placeholder.cols}}" ng-repeat="(placeholderKey, placeholder) in row track by placeholderKey" ng-include="'recursion.html'" />
    </div>
    <div class="row" ng-if="item.nav_item_type==2">
        <div class="col-md-12">
            <?= Module::t('view_update_page_is_module'); ?>
        </div>
    </div>
    <div class="row" ng-if="item.nav_item_type==3">
        <div ng-switch="typeData.type">
            <div ng-switch-when="1" class="col-md-12">
                <p><?= Module::t('view_update_page_is_redirect_internal'); ?></p>
            </div>
            <div ng-switch-when="2" class="col-md-12">
                <p><?= Module::t('view_update_page_is_redirect_external'); ?>.</p>
            </div>
        </div>
    </div>
</div>
<div class="cmsadmin-page" ng-show="!isTranslated && loaded">
    <div class="alert alert-info"><?= Module::t('view_update_no_translations'); ?></div>
    <div ng-controller="CopyPageController">
        <h3><?= Module::t('view_index_add_page_from_language'); ?></h3>
        <p><?= Module::t('view_index_add_page_from_language_info'); ?></p>
        <p><button ng-click="loadItems()" ng-show="!isOpen" class="btn"><?= Module::t('view_index_yes'); ?></button></p>
        <div ng-show="isOpen">
            <ul class="list-group" style="margin-bottom:25px;">
                <li ng-repeat="item in items" class="list-group-item"><input type="radio" ng-model="selection" value="{{item.id}}"><label ng-click="select(item);">{{item.lang.name}} <i>&laquo; {{ item.title }} &raquo;</i></label></li>
            </ul>
            <div ng-show="itemSelection" style=" margin-bottom:25px;">
                <zaa-text label="<?= Module::t('view_index_page_title'); ?>" model="itemSelection.title"></zaa-text>
                <zaa-text label="<?= Module::t('view_index_page_alias'); ?>" model="itemSelection.alias"></zaa-text>
                <button ng-click="save()" class="btn btn-save btn-icon" type="button"><?= Module::t('view_index_page_btn_save'); ?></button>
            </div>
        </div>
    </div>
    <div ng-controller="CmsadminCreateInlineController">
        <h3><?= Module::t('view_index_add_page_empty'); ?></h3>
        <create-form data="data"></create-form>
    </div>
</div>