<?php
use luya\admin\ngrest\render\RenderCrud;
use luya\admin\Module;

?>
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
        $scope.config.inline = <?= (int) $config->inline; ?>;
        $scope.orderBy = '<?= $config->getDefaultOrderDirection() . $config->getDefaultOrderField(); ?>';
        $scope.saveCallback = <?= $config->getOption('saveCallback'); ?>;
        <?php if ($config->groupByField): ?>
        $scope.config.groupBy = 1;
        $scope.config.groupByField = "<?= $config->groupByField; ?>";
        <?php endif; ?>
    });
</script>
<div ng-controller="<?php echo $config->hash; ?>" ng-init="init()">
    <!-- This fake ui-view is used to render the detail item, which actuals uses the parent scope in the ui router controller. -->
    <div style="visibility:hidden;" ui-view></div>
    <div ng-if="service">

        <div class="tabs">
            <ul>
                <li class="tabs__item" ng-class="{'tabs__item--active' : crudSwitchType==0}">
                    <a class="tabs__anchor" ng-click="switchTo(0, true)"><i class="material-icons tabs__icon">menu</i> <?= Module::t('ngrest_crud_btn_list'); ?></a>
                </li>

                <?php if ($canCreate && $config->getPointer('create')): ?>
                    <li class="tabs__item" ng-class="{'tabs__item--active' : crudSwitchType==1}">
                        <a class="tabs__anchor" style="" ng-click="switchTo(1)"><i class="material-icons tabs__icon">add_box</i> <?= Module::t('ngrest_crud_btn_add'); ?></a>
                    </li>
                <?php endif; ?>

                <li ng-show="crudSwitchType==2" class="tabs__item" ng-class="{'tabs__item--active' : crudSwitchType==2}">
                    <a class="tabs__anchor" ng-click="switchTo(0, true)"><i class="material-icons tabs__icon">cancel</i> <?= Module::t('ngrest_crud_btn_close'); ?></a>
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
                    <div class="row">
                        <div class="col <?php if (!empty($config->filters)): ?>m12 l6<?php else: ?>m6 l8<?php endif; ?>">
                            <div class="input input--text">
                                <div class="input__field-wrapper">
                                    <input class="input__field" ng-model="config.searchQuery" type="text" placeholder="<?= Module::t('ngrest_crud_search_text'); ?>" />
                                </div>
                                
                            </div>
                            <div ng-show="config.minLengthWarning">
                               <p>The search keyword must at least have 3 chars.</p>
                            </div>
                        </div>
                        <div class="col <?php if (!empty($config->filters)): ?>m6 l3<?php else: ?>m12 l4<?php endif; ?>">
                            <div class="input input--select input--vertical input--full-width">
                                <div class="input__field-wrapper">
                                    <i class="input__select-arrow material-icons">keyboard_arrow_down</i>
                                    <select class="input__field" ng-change="changeGroupByField()" ng-model="config.groupByField">
                                        <option value="0">Nach Feld gruppieren</option>
                                        <?php foreach ($config->getPointer('list') as $item): ?>
                                            <option value="<?= $item['name']; ?>"><?= $item['alias']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($config->filters)): ?>
                            <div class="col m6 l3">
                                <div class="input input--select input--vertical input--full-width">
                                    <div class="input__field-wrapper">
                                        <i class="input__select-arrow material-icons">keyboard_arrow_down</i>
                                        <select class="input__field" ng-change="realoadCrudList()" ng-model="config.filter">
                                            <option value="0">Filter auswählen</option>
                                            <?php foreach (array_keys($config->filters) as $name): ?>
                                                <option value="<?= $name; ?>"><?= $name; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="button-right__right">
                    <div>
                        <button type="button" ng-show="!exportDownloadButton && !exportLoading" ng-click="exportData()" class="btn cyan btn--small" style="width: 100%;">
                            <i class="material-icons left">unarchive</i> <?= Module::t('ngrest_crud_csv_export_btn'); ?>
                        </button>
                        <div ng-show="exportLoading" class="btn disabled btn--small center" style="width: 100%;"><i class="material-icons spin">cached</i></div>
                        <div ng-show="exportDownloadButton">
                            <button ng-click="exportDownload()" class="btn light-green btn--small" type="button" style="width: 100%;"><i class="material-icons left">file_download</i> <?= Module::t('ngrest_crud_csv_export_btn_dl'); ?></button>
                        </div>
                    </div>
                </div>
            </div>

            <div ng-if="pager && !config.pagerHiddenByAjaxSearch" style="text-align: center;">
                <ul class="pagination">
                    <li class="waves-effect" ng-class="{'disabled' : pager.currentPage == 1}" ng-click="pagerPrevClick()"><a><i class="material-icons">chevron_left</i></a></li>
                    <li class="waves-effect" ng-repeat="pageId in pager.pages" ng-class="{'active': pageId == pager.currentPage}" ng-click="realoadCrudList(pageId)">
                        <a>{{pageId}}</a>
                    </li>
                    <li class="waves-effect" ng-class="{'disabled' : pager.currentPage == pager.pageCount}" ng-click="pagerNextClick()"><a><i class="material-icons">chevron_right</i></a></li>
                </ul>
            </div>

            <table class="striped responsive-table hoverable">
                <thead>
                <tr>
                    <?php foreach ($config->getPointer('list') as $item): ?>
                        <th ng-hide="config.groupBy && config.groupByField == '<?= $item['name']; ?>'"><?php echo $item['alias']; ?> <i ng-click="changeOrder('<?php echo $item['name']; ?>', '+')" ng-class="{'active-orderby' : isOrderBy('+<?php echo $item['name']; ?>') }" class="material-icons grid-sort-btn">keyboard_arrow_up</i> <i ng-click="changeOrder('<?php echo $item['name']; ?>', '-')" ng-class="{'active-orderby' : isOrderBy('-<?php echo $item['name']; ?>') }" class="material-icons grid-sort-btn">keyboard_arrow_down</i></th>
                    <?php endforeach; ?>
                    <?php if (count($this->context->getButtons()) > 0): ?>
                        <th style="text-align:right;"><span class="grid-data-length">{{data.list.length}} <?= Module::t('ngrest_crud_rows_count'); ?></span></th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody ng-repeat="(key, items) in data.listArray | groupBy: config.groupByField" ng-init="viewToggler[key]=true">
                <tr ng-if="config.groupBy" class="table__group">
                    <td colspan="100"> <!--ng-click="IS IT THIS?"-->
                        <strong>{{key}}</strong>
                        <i class="material-icons right" ng-click="viewToggler[key]=true" ng-show="!viewToggler[key]">keyboard_arrow_up</i>
                        <i class="material-icons right" ng-click="viewToggler[key]=false" ng-show="viewToggler[key]">keyboard_arrow_down</i>
                    </td>
                </tr>
                <tr ng-repeat="(k, item) in items | srcbox:config.searchString" ng-show="viewToggler[key]" ng-class="{'crud__item-highlight': isHighlighted(item)}">
                    <?php foreach ($config->getPointer('list') as $item): ?>
                        <?php foreach ($this->context->createElements($item, RenderCrud::TYPE_LIST) as $element): ?>
                            <td ng-hide="config.groupBy && config.groupByField == '<?= $item['name']; ?>'"><?php echo $element['html']; ?></td>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    <?php if (count($this->context->getButtons()) > 0): ?>
                        <td style="text-align:right;">
                            <?php foreach ($this->context->getButtons() as $item): ?>
                                <a class="crud__button waves-effect waves-light btn-flat btn--bordered" ng-click="<?php echo $item['ngClick']; ?>"><i class="material-icons<?php if (!empty($item['label'])): ?> left<?php endif; ?>"><?php echo $item['icon']; ?></i><?php echo $item['label']; ?></a>
                            <?php endforeach; ?>
                        </td>
                    <?php endif; ?>
                </tr>
                </tbody>
            </table>

            <div ng-if="pager && !config.pagerHiddenByAjaxSearch" style="text-align: center;">
                <ul class="pagination">
                    <li class="waves-effect" ng-class="{'disabled' : pager.currentPage == 1}" ng-click="pagerPrevClick()"><a><i class="material-icons">chevron_left</i></a></li>
                    <li class="waves-effect" ng-repeat="pageId in pager.pages" ng-class="{'active': pageId == pager.currentPage}" ng-click="realoadCrudList(pageId)">
                        <a>{{pageId}}</a>
                    </li>
                    <li class="waves-effect" ng-class="{'disabled' : pager.currentPage == pager.pageCount}" ng-click="pagerNextClick()"><a><i class="material-icons">chevron_right</i></a></li>
                </ul>
            </div>

            <div ng-show="data.list.length == 0" class="alert alert--info"><?= Module::t('ngrest_crud_empty_row'); ?></div>
        </div>
        <!-- /LIST -->

        <div class="card-panel" ng-if="crudSwitchType==1" <?php if (!$config->inline): ?>zaa-esc="closeCreate()"<?php endif; ?>>

            <?php if ($canCreate && $config->getPointer('create')): ?>
                <form name="formCreate" role="form" ng-submit="submitCreate()">

                    <!-- MODAL CONTENT -->
                    <div class="modal__content">
                        <?php foreach ($this->context->forEachGroups(RenderCrud::TYPE_CREATE) as $key => $group): ?>
                            <?php if (!$group['is_default']): ?>
                                <div class="form-group" ng-init="groupToggler[<?= $key; ?>] = <?= (int) !$group['collapsed']; ?>">
                                <p class="form-group__title" ng-click="groupToggler[<?= $key; ?>] = !groupToggler[<?= $key; ?>]">
                                    <?= $group['name']; ?>
                                    <span class="material-icons right" ng-show="groupToggler[<?= $key; ?>]">keyboard_arrow_up</span>
                                    <span class="material-icons right" ng-show="!groupToggler[<?= $key; ?>]">keyboard_arrow_down</span>
                                </p>
                                <div class="form-group__fields" ng-show="groupToggler[<?= $key; ?>]">
                            <?php endif; ?>

                            <?php foreach ($group['fields'] as $field => $fieldItem): ?>
                                <div class="row">
                                    <?php foreach ($this->context->createElements($fieldItem, RenderCrud::TYPE_CREATE) as $element): ?>
                                        <?php echo $element['html']; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>

                            <?php if (!$group['is_default']): ?>
                                </div> <!-- /.form-group__fields -->
                                </div> <!-- /.form-group -->
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal__footer">
                        <div class="row">
                            <div class="col s12">
                                <div class="right">
                                    <button class="btn waves-effect waves-light" type="submit" ng-disabled="createForm.$invalid">
                                        <?= Module::t('ngrest_crud_btn_create'); ?> <i class="material-icons right">check</i>
                                    </button>
                                    <button class="btn waves-effect waves-light red" type="button" ng-click="closeCreate()">
                                        <i class="material-icons left">cancel</i> <?= Module::t('button_abort'); ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            <?php endif; ?>
        </div>

        <div class="card-panel" ng-if="crudSwitchType==2" <?php if (!$config->inline): ?>zaa-esc="closeUpdate()"<?php endif; ?>>
            <?php if ($canUpdate && $config->getPointer('update')): ?>
                <form name="formUpdate" role="form" ng-submit="submitUpdate()">
                    <!-- MODAL CONTENT -->
                    <div class="modal__content">
                        <?php foreach ($this->context->forEachGroups(RenderCrud::TYPE_UPDATE) as $key => $group): ?>
                            <?php if (!$group['is_default']): ?>
                                <div ng-init="groupToggler[<?= $key; ?>] = <?= (int) !$group['collapsed']; ?>">
                                <h5 ng-click="groupToggler[<?= $key; ?>] = !groupToggler[<?= $key; ?>]"><?= $group['name']; ?> +/- Toggler</h5>
                                <div style="border:1px solid #F0F0F0; margin-bottom:20px;" ng-show="groupToggler[<?= $key; ?>]">
                            <?php endif; ?>
                            <?php foreach ($group['fields'] as $field => $fieldItem): ?>
                                <div class="row">
                                    <?php foreach ($this->context->createElements($fieldItem, RenderCrud::TYPE_UPDATE) as $element): ?>
                                        <?php echo $element['html']; ?>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                            <?php if (!$group['is_default']): ?>
                                </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <!-- /MODAL CONTENT -->

                    <!-- MODAL FOOTER -->
                    <div class="modal__footer">
                        <div class="row">
                            <div class="col s12">
                                <div class="right">
                                    <button class="btn waves-effect waves-light" type="submit" ng-disabled="updateForm.$invalid">
                                        <?= Module::t('button_save'); ?> <i class="material-icons right">check</i>
                                    </button>
                                    <button class="btn waves-effect waves-light red" type="button" ng-click="closeUpdate()">
                                        <i class="material-icons left">cancel</i> <?= Module::t('button_abort'); ?>
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
    
     <modal is-modal-hidden="activeWindowModal" <?php if (!$config->inline): ?>zaa-esc="closeActiveWindow()"<?php endif; ?>>
        <div class="modal-content" compile-html ng-bind-html="data.aw.content"></div>
    </modal>

</div>