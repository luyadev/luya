<script type="text/ng-template" id="recursion.html">
<h4 class="cmsadmin-container-title">{{placeholder.label}}</h4>
<div class="card">
    <div class="card-block">
        <div ng-if="placeholder.__nav_item_page_block_items.length == 0" dnd dnd-drag-disabled dnd-model="placeholder" dnd-isvalid="true" dnd-ondrop="dropItemPlaceholder(dragged,dropped,position)" dnd-css="{onDrag: 'drag-start', onHover: 'b-hover', onHoverTop: 'b-top', onHoverMiddle: 'b-left', onHoverBottom: 'b-bottom'}">LEER</div>
        <div ng-class="{'block-is-layout' : block.is_container}" ng-repeat="(key, block) in placeholder.__nav_item_page_block_items track by key" ng-controller="PageBlockEditController">
            <div class="block" dnd dnd-model="block" dnd-isvalid="true" dnd-disable-drag-middle dnd-ondrop="dropItem(dragged,dropped,position)" dnd-css="{onDrag: 'drag-start', onHover: 'b-hover', onHoverTop: 'b-top', onHoverMiddle: 'b-left', onHoverBottom: 'b-bottom'}">
                <div class="block-toolbar">
                    <div class="toolbar-item">
                        <i class="material-icons">{{block.icon}}</i>
                        <span>{{block.name}}</span>
                    </div>
                    <div class="toolbar-item ml-auto" ng-click="copyBlock()">
                        <button class="toolbar-button">
                            <i class="material-icons">content_copy</i>
                        </button>
                    </div>
                    <div class="toolbar-item" ng-click="toggleHidden()" ng-show="block.is_hidden==0">
                        <button class="toolbar-button">
                            <i class="material-icons">visibility</i>
                        </button>
                    </div>
                    <div class="toolbar-item" ng-click="toggleHidden()" ng-show="block.is_hidden==1">
                        <button class="toolbar-button">
                            <i class="material-icons">visibility_off</i>
                        </button>
                    </div>
                    <div class="toolbar-item" ng-click="removeBlock()">
                        <button class="toolbar-button">
                            <i class="material-icons">delete</i>
                        </button>
                    </div>
                    <div ng-show="isEditable()" ng-click="toggleEdit()" class="toolbar-item">
                        <button class="toolbar-button">
                            <i class="material-icons">edit</i>
                        </button>
                    </div>
                </div>
                <modal is-modal-hidden="modalHidden" title="Settings">
                    <form class="block__edit" ng-if="edit" ng-submit="save()">
                        <div ng-repeat="field in block.vars" ng-hide="field.invisible" class="row">
                            <div class="col">
                                <zaa-injector dir="field.type" options="field.options" fieldid="{{field.id}}" fieldname="{{field.var}}" initvalue="{{field.initvalue}}" placeholder="{{field.placeholder}}" label="{{field.label}}" model="data[field.var]"></zaa-injector>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="material-icons left">done</i> Save</button>
                    </form>
                </modal>
                <div ng-if="!block.is_container" ng-click="toggleEdit()" class="block-front" ng-bind-html="renderTemplate(block.twig_admin, data, cfgdata, block, block.extras)" />
                <div ng-if="block.__placeholders.length" class="block-front">
                    <div class="row" ng-repeat="(inlineRowKey, row) in block.__placeholders track by inlineRowKey">
                        <div class="col-xl-{{placeholder.cols}}" ng-repeat="(placeholderInlineKey, placeholder) in row track by placeholderInlineKey" ng-include="'recursion.html'" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</script>
<?= $this->render('_navitem_settings'); ?>
<ul class="nav nav-tabs" role="tablist">
    <li class="nav-item nav-item-title">
        <span class="flag flag-{{lang.short_code}}">
            <span class="flag-fallback">{{lang.name}}</span>
        </span>
        <span>{{ item.title }}</span>
    </li>
    <li class="nav-item" ng-repeat="versionItem in typeData" ng-if="item.nav_item_type==1">
        <a class="nav-link active">
            <span>{{ versionItem.version_alias }}</span>
        </a>
    </li>
    <li class="nav-item nav-item-alternative">
        <a class="nav-link">
            <i class="material-icons">add_box</i>
        </a>
    </li>
    <li class="nav-item nav-item-alternative nav-item-icon ml-auto">
        <a class="nav-link" ng-click="itemSettingsOverlay=!itemSettingsOverlay">
            <i class="material-icons">edit</i>
        </a>
    </li>
    <li class="nav-item nav-item-alternative nav-item-icon">
        <a ng-href="{{homeUrl}}preview/{{item.id}}?version={{currentPageVersion}}" target="_blank" class="nav-link" ng-show="!liveEditState">
            <i class="material-icons">open_in_new</i>
        </a>
        <a ng-click="openLiveUrl(item.id, currentPageVersion)" ng-show="liveEditState" class="nav-link">
            <i class="material-icons">open_in_new</i>
        </a>
    </li>
</ul>
<div class="cmsadmin-page" ng-if="isTranslated">
    <div class="row" ng-if="item.nav_item_type==1" ng-repeat="(key, row) in container.__placeholders track by key">
        <div class="col-xl-{{placeholder.cols}}" ng-repeat="(placeholderKey, placeholder) in row track by placeholderKey" ng-include="'recursion.html'" />
    </div>
    <div class="row" ng-if="item.nav_item_type==2">
        Module
    </div>
    <div class="row" ng-if="item.nav_item_type==3">
        Redirect
    </div>
</div>
<div class="cmsadmin-page" ng-if="!isTranslated">
    <p>Not yet translated</p>
</div>