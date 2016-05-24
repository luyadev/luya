<script>
    activeWindowCallbackUrl = '<?php echo $activeWindowCallbackUrl;?>';
    ngrestConfigHash = '<?php echo $config->hash; ?>';
    zaa.bootstrap.register('<?php echo $config->hash; ?>', function($scope, $controller) {
        /* extend class */
        $.extend(this, $controller('CrudController', { $scope : $scope }));
        /* local controller config */
        $scope.config.apiListQueryString = '<?php echo $this->context->apiQueryString('list'); ?>';
        $scope.config.apiUpdateQueryString = '<?php echo $this->context->apiQueryString('update'); ?>';
        $scope.config.apiEndpoint = '<?php echo $this->context->getRestUrl(); ?>';
        $scope.config.list = <?php echo $this->context->getFieldsJson('list'); ?>;
        $scope.config.create = <?php echo $this->context->getFieldsJson('create'); ?>;
        $scope.config.update = <?php echo $this->context->getFieldsJson('update'); ?>;
        $scope.config.ngrestConfigHash = '<?php echo $config->hash; ?>';
        $scope.config.activeWindowCallbackUrl = '<?php echo $activeWindowCallbackUrl; ?>';
        $scope.config.pk = '<?php echo $this->context->getPrimaryKey(); ?>';
    });
</script>

<div ng-controller="<?php echo $config->hash; ?>" ng-init="init()">
	<!-- This fake ui-view is used to render the detail item, which actuals uses the parent scope in the ui router controller. -->
	<div style="visibility:hidden;" ui-view></div>
    <div>

        <div class="tabs">
            <ul>
                <li class="tabs__item" ng-class="{'tabs__item--active' : crudSwitchType==0}">
                    <a class="tabs__anchor" ng-click="switchTo(0)"><i class="material-icons tabs__icon">menu</i> <?php echo \admin\Module::t('ngrest_crud_btn_list'); ?></a>
                </li>

                <?php if ($canCreate && $config->getPointer('create')): ?>
                    <li class="tabs__item" ng-class="{'tabs__item--active' : crudSwitchType==1}">
                        <a class="tabs__anchor" style="" ng-click="switchTo(1)"><i class="material-icons tabs__icon">add_box</i> <?php echo \admin\Module::t('ngrest_crud_btn_add'); ?></a>
                    </li>
                <?php endif; ?>
                
                <li ng-show="crudSwitchType==2" class="tabs__item" ng-class="{'tabs__item--active' : crudSwitchType==2}">
                    <a class="tabs__anchor" ng-click="switchTo(0)"><i class="material-icons tabs__icon">cancel</i> <?php echo \admin\Module::t('ngrest_crud_btn_close'); ?></a>
                </li>
            </ul>
        </div>

        <div class="langswitch crud__langswitch" ng-if="crudSwitchType!==0">
            <a ng-repeat="lang in AdminLangService.data" ng-click="AdminLangService.toggleSelection(lang)" ng-class="{'langswitch__item--active' : AdminLangService.isInSelection(lang.short_code)}" class="langswitch__item [ waves-effect waves-blue ][ btn-flat btn--small btn--bold ] ng-binding ng-scope">
                <span class="flag flag--{{lang.short_code}}">
                    <span class="flag__fallback">{{lang.name}}</span>
                </span>
            </a>
        </div>
        
        <!-- LIST -->
        <div class="card-panel" ng-show="crudSwitchType==0">

            <div class="button-right" style="margin-bottom:30px;">

                <div class="button-right__left">
                    <div class="input input--text">
                        <div class="input__field-wrapper">
                            <input class="input__field" id="searchString" ng-model="searchString" ng-change="evalSearchString()" type="text" placeholder="<?php echo \admin\Module::t('ngrest_crud_search_text'); ?>" />
                        </div>
                    </div>
                </div>

                <div class="button-right__right">
                    <div>
                        <button type="button" ng-show="!exportDownloadButton && !exportLoading" ng-click="exportData()" class="btn cyan btn--small" style="width: 100%;">
                            <i class="material-icons left">unarchive</i> <?= \admin\Module::t('ngrest_crud_csv_export_btn'); ?>
                        </button>
                        <div ng-show="exportLoading" class="btn disabled btn--small center" style="width: 100%;"><i class="material-icons spin">cached</i></div>
                        <div ng-show="exportDownloadButton">
                            <button ng-click="exportDownload()" class="btn light-green btn--small" type="button" style="width: 100%;"><i class="material-icons left">file_download</i> <?= \admin\Module::t('ngrest_crud_csv_export_btn_dl'); ?></button>
                        </div>
                    </div>
                </div>

            </div>
            

            <div ng-show="deleteErrors.length">
                <div class="alert alert--danger">
                    <ul>
                        <li ng-repeat="e in deleteErrors">{{e}}</li>
                    </ul>
                </div>
            </div>
            <table class="striped responsive-table hoverable">
                <thead>
                    <tr>
                        <?php foreach ($config->getPointer('list') as $item): ?>
                            <th><?php echo $item['alias']; ?> <i ng-click="changeOrder('<?php echo $item['name']; ?>', '+')" ng-class="{'active-orderby' : isOrderBy('+<?php echo $item['name']; ?>') }" class="material-icons grid-sort-btn">keyboard_arrow_up</i> <i ng-click="changeOrder('<?php echo $item['name']; ?>', '-')" ng-class="{'active-orderby' : isOrderBy('-<?php echo $item['name']; ?>') }" class="material-icons grid-sort-btn">keyboard_arrow_down</i></th>
                        <?php endforeach; ?>
                        <?php if (count($this->context->getButtons()) > 0): ?>
                            <th style="text-align:right;"><span class="grid-data-length">{{data.list.length}} <?php echo \admin\Module::t('ngrest_crud_rows_count'); ?></span></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="(key, item) in data.list | srcbox:searchString" ng-class="{'crud__item-highlight': isHighlighted(item)}">
                        <?php foreach ($config->getPointer('list') as $item): ?>
                            <?php foreach ($this->context->createElements($item, \admin\ngrest\render\RenderCrud::TYPE_LIST) as $element): ?>
                                <td><?php echo $element['html']; ?></td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                        <?php if (count($this->context->getButtons()) > 0): ?>
                        <td style="text-align:right;">
                            <?php foreach ($this->context->getButtons() as $item): ?>
                            <a class="waves-effect waves-light btn-flat btn--bordered" ng-click="<?php echo $item['ngClick']; ?>"><i class="material-icons<?php if (!empty($item['label'])): ?> left<?php endif; ?>"><?php echo $item['icon']; ?></i><?php echo $item['label']; ?></a>
                            <?php endforeach; ?>
                        </td>
                        <?php endif; ?>
                    </tr>
                </tbody>
            </table>
            <div ng-show="data.list.length == 0" class="alert alert--info"><?php echo \admin\Module::t('ngrest_crud_empty_row'); ?></div>
        </div>
        <!-- /LIST -->
    
        <div class="card-panel" ng-show="crudSwitchType==1" zaa-esc="closeCreate()">

            <?php if ($canCreate && $config->getPointer('create')): ?>
                <form name="formCreate" role="form" ng-submit="submitCreate()">

                    <!-- MODAL CONTENT -->
                    <div class="modal__content">
                        
                        <?php foreach ($config->getPointer('create') as $k => $item): ?>
                            <div class="row">
                                <?php foreach ($this->context->createElements($item, \admin\ngrest\render\RenderCrud::TYPE_CREATE) as $element): ?>
                                    <?php echo $element['html']; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <div class="red lighten-2" style="color:white;" ng-show="createErrors.length">
                            <ul>
                                <li ng-repeat="error in createErrors" style="padding:6px;">- {{error.message}}</li>
                            </ul>
                        </div>

                    </div>

                    <div class="modal__footer">
                        <div class="row">
                            <div class="col s12">
                                <div class="right">
                                    <button class="btn waves-effect waves-light" type="submit" ng-disabled="createForm.$invalid">
                                        <?php echo \admin\Module::t('ngrest_crud_btn_create'); ?> <i class="material-icons right">check</i>
                                    </button>
                                    <button class="btn waves-effect waves-light red" type="button" ng-click="closeCreate()">
                                        <i class="material-icons left">cancel</i> <?php echo \admin\Module::t('button_abort'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            <?php endif; ?>
        </div>
    
        <div class="card-panel" ng-show="crudSwitchType==2" zaa-esc="closeUpdate()">
            <?php if ($canUpdate && $config->getPointer('update')): ?>
                <form name="formUpdate" role="form" ng-submit="submitUpdate()">
                    <!-- MODAL CONTENT -->
                    <div class="modal__content">
                        <?php foreach ($config->getPointer('update') as $k => $item): ?>
                            <div class="row">
                                <?php foreach ($this->context->createElements($item, \admin\ngrest\render\RenderCrud::TYPE_UPDATE) as $element): ?>
                                    <?php echo $element['html']; ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>

                        <div class="red lighten-2" style="color:white;" ng-show="updateErrors.length">
                            <ul>
                                <li ng-repeat="error in updateErrors" style="padding:6px;">- {{error.message}}</li>
                            </ul>
                        </div>
                    </div>
                    <!-- /MODAL CONTENT -->

                    <!-- MODAL FOOTER -->
                    <div class="modal__footer">
                        <div class="row">
                            <div class="col s12">
                                <div class="right">
                                    <button class="btn waves-effect waves-light" type="submit" ng-disabled="updateForm.$invalid">
                                        <?php echo \admin\Module::t('button_save'); ?> <i class="material-icons right">check</i>
                                    </button>
                                    <button class="btn waves-effect waves-light red" type="button" ng-click="closeUpdate()">
                                        <i class="material-icons left">cancel</i> <?php echo \admin\Module::t('button_abort'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /MODAL FOOTER -->
                </form>
            <?php endif; ?>
        </div>

    </div>

    <!-- activeWindow MODAL -->
    <div ng-show="activeWindowModal" class="modal__wrapper" zaa-esc="closeActiveWindow()">
        <div class="modal">
            <button class="btn waves-effect waves-light modal__close btn-floating red" type="button" ng-click="closeActiveWindow()">
                <i class="material-icons">close</i>
            </button>
            <div class="modal-content" compile-html ng-bind-html="data.aw.content"></div>
        </div>
        <div class="modal__background"></div>
    </div>

</div>