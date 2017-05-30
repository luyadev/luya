<?php
use luya\admin\ngrest\render\RenderCrud;
use luya\admin\Module;

/* @var $config \luya\admin\ngrest\ConfigInterface */
/* @var $this \luya\admin\ngrest\render\RenderCrudView */
/* @var $isInline boolean Whether current window mode is inline or not */
$this->beginPage();
$this->beginBody();
?>
<?php $this->registerAngularControllerScript(); ?>
<div ng-controller="<?= $config->hash; ?>" ng-init="init()" class="crud">
    <!-- This fake ui-view is used to render the detail item, which actuals uses the parent scope in the ui router controller. -->
    <div style="visibility:hidden;" ui-view></div>
    <div class="crud-header">
        <h1 class="crud-title">TITLE</h1>
        <div class="crud-toolbar">
            <button type="button" class="btn btn-sm btn-link btn-icon"><i class="material-icons">settings</i></button>
            <div class="btn-group">
                <button class="btn btn-sm btn-link btn-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="material-icons">more_vert</i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#"><i class="material-icons">get_app</i> <span>Export CSV</span></a>
                    <a class="dropdown-item" href="#"><i class="material-icons">done_all</i> <span>Mark all as done</span></a>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" role="tab">
                <i class="material-icons">list</i>
                <span><?= Module::t('ngrest_crud_btn_list'); ?></span>
            </a>
        </li>
        <li class="nav-item mr-auto"> <!-- THE LAST ONE OF THE REGULAR CRUD TABS NEEDS TO HAVE THE MR-AUTO CLASS -->
            <a class="nav-link" data-toggle="tab" role="tab">
                <i class="material-icons">add_box</i>
                <span><?= Module::t('ngrest_crud_btn_add'); ?></span>
            </a>
        </li>

        <li class="nav-item nav-item-border-only" ng-repeat="lang in AdminLangService.data">
            <a class="nav-link active" ng-click="AdminLangService.toggleSelection(lang)" ng-class="{'active' : AdminLangService.isInSelection(lang.short_code)}" role="tab">
                <span class="flag flag--{{lang.short_code}}">
                    <span class="flag__fallback ng-binding">{{lang.name}}</span>
                </span>
            </a>
        </li>
    </ul>

    <div class="tab-content">

        <div class="tab-pane active" id="entries" role="tabpanel">

            <div class="tab-padded">
                <div class="row mt-2">
                    <div class="col-md-4 col-lg-6 col-xl-6 col-xxxl-8">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon">
                                <i class="material-icons">search</i>
                            </div>
                            <input class="form-control" ng-model="config.searchQuery" type="text" placeholder="<?= Module::t('ngrest_crud_search_text'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 col-xxxl-2">
                        <select class="form-control" id="group-by">
                            <option>Group by ...</option>
                            <option>Field 1</option>
                            <option>Field 2</option>
                            <option>Field 3</option>
                            <option>Field 4</option>
                            <option>Field 5</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-lg-3 col-xl-3 col-xxxl-2">
                        <select class="form-control" id="group-by">
                            <option>Filter by ...</option>
                            <option>Field 1</option>
                            <option>Field 2</option>
                            <option>Field 3</option>
                            <option>Field 4</option>
                            <option>Field 5</option>
                        </select>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-striped table-align-middle mt-4">
                <thead class="thead-default">
                    <tr>
                        <?php foreach ($config->getPointer('list') as $item): ?>
                        <th>
                            <span><?= $item['alias']; ?></span>
                            <div class="table-sorter table-sorter-up is-active">
                                <i class="material-icons">keyboard_arrow_up</i>
                            </div>
                            <div class="table-sorter table-sorter-down">
                                <i class="material-icons">keyboard_arrow_down</i>
                            </div>
                        </th>
                        <?php endforeach; ?>
                        <th class="tab-padding-right text-right">
                            <span class="crud-counter">{{data.listArray.length}} <?= Module::t('ngrest_crud_rows_count'); ?></span>
                        </th>
                    </tr>
                </thead>
                <tbody ng-repeat="(key, items) in data.listArray | groupBy: config.groupByField" ng-init="viewToggler[key]=true">
                    <tr ng-repeat="(k, item) in items | srcbox:config.searchString" ng-show="viewToggler[key]">
                        <?php foreach ($config->getPointer('list') as $item): ?>
                            <?php foreach ($this->context->createElements($item, RenderCrud::TYPE_LIST) as $element): ?>
                                 <td><?= $element['html']; ?></td>
                             <?php endforeach; ?>
                         <?php endforeach; ?>
                         <?php if (count($this->context->getButtons()) > 0): ?>
                        <td class="text-right">
                            <?php foreach ($this->context->getButtons() as $item): ?>
                            <button type="button" class="btn btn-sm btn-link btn-icon" ng-click="<?= $item['ngClick']; ?>"><i class="material-icons"><?= $item['icon']; ?></i></button>
                            <?php endforeach; ?>
                            <!-- 
                            <div class="btn-group">
                                <button class="btn btn-sm btn-link btn-icon" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#"><i class="material-icons">build</i> <span>Build</span></a>
                                    <a class="dropdown-item" href="#"><i class="material-icons">done</i> <span>Mark as done</span></a>
                                    <a class="dropdown-item" href="#"><i class="material-icons">report</i> <span>Report</span></a>
                                </div>
                            </div>
                             -->
                        </td>
                        <?php endif; ?>
                    </tr>
                </tbody>
            </table>

            <ul class="pagination" ng-if="pager && !config.pagerHiddenByAjaxSearch">
                <li class="page-item page-item-icon disabled" ng-class="{'disabled' : pager.currentPage == 1}" >
                    <a class="page-link" ng-click="pagerPrevClick()" tabindex="-1"><i class="material-icons">keyboard_arrow_left</i></a>
                </li>
                <li class="page-item active" ng-repeat="pageId in pager.pages" ng-class="{'active': pageId == pager.currentPage}">
                    <a class="page-link" ng-click="realoadCrudList(pageId)">{{pageId}}</a>
                </li>
                <li class="page-item page-item-icon" ng-class="{'disabled' : pager.currentPage == pager.pageCount}">
                    <a class="page-link"  ng-click="pagerNextClick()"><i class="material-icons">keyboard_arrow_right</i></a>
                </li>
            </ul>

        </div>

        <div class="tab-pane tab-padded" id="add" role="tabpanel">
            TAB 2
        </div>

    </div>

</div>
<?php $this->endBody(); ?>
<?php $this->endPage(); ?>