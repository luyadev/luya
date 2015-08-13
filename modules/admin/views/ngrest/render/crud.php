<script>
activeWindowCallbackUrl = '<?= $activeWindowCallbackUrl;?>';
ngrestConfigHash = '<?= $config->hash; ?>';
zaa.bootstrap.register('<?=$config->hash; ?>', function($scope, $controller) {
    /* extend class */
    $.extend(this, $controller('CrudController', { $scope : $scope }));
    /* local controller config */
    $scope.config.apiListQueryString = '<?= $this->context->apiQueryString('list'); ?>';
    $scope.config.apiUpdateQueryString = '<?= $this->context->apiQueryString('update'); ?>';
    $scope.config.apiEndpoint = '<?= $this->context->getRestUrl();?>';
    $scope.config.list = <?=json_encode($this->context->getFields('list'));?>;
    $scope.config.create = <?=json_encode($this->context->getFields('create'));?>;
    $scope.config.update = <?=json_encode($this->context->getFields('update'));?>;
    $scope.config.ngrestConfigHash = '<?= $config->hash; ?>';
    $scope.config.activeWindowCallbackUrl = '<?= $activeWindowCallbackUrl;?>';
});
</script>

<div ng-controller="<?=$config->hash; ?>" ng-init="init()">
<? if($canCreate): ?>
<a ng-show="config.create.length" class="btn-floating btn-large waves-effect waves-light right red" style="margin:20px;" ng-click="openCreate()"><i class="mdi-content-add"></i></a>
<? endif; ?>
<div class="card-panel" ng-show="loading">
    <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

<!-- LIST -->
<div class="card-panel" ng-show="!loading">

    <div class="row">
        <div class="input-field col s6">
            <i class="mdi-action-search prefix"></i>
            <input id="searchString" ng-model="searchString" type="text">
            <label for="searchString">in der Tabelle <strong>{{currentMenuItem.alias}}</strong> suchen.</label>
        </div>
    </div>
    <div ng-show="deleteErrors.length">
        <div class="alert alert--danger">
            <ul>
                <li ng-repeat="e in deleteErrors">{{e}}</li>
            </ul>
        </div>
    </div>
    <table class="striped hoverable responsive-table">
    <thead>
        <tr>
            <?php foreach ($config->getPointer('list') as $item): ?>
                <th><?= $item['alias']; ?> <i ng-click="changeOrder('<?= $item['name']; ?>', '+')" ng-class="{'active-orderby' : isOrderBy('+<?= $item['name']; ?>') }" class="mdi-hardware-keyboard-arrow-up grid-sort-btn"></i> <i ng-click="changeOrder('<?= $item['name']; ?>', '-')" ng-class="{'active-orderby' : isOrderBy('-<?= $item['name']; ?>') }" class="mdi-hardware-keyboard-arrow-down grid-sort-btn"></i></th>
            <?php endforeach; ?>
            <?php if (count($this->context->getButtons()) > 0): ?>
                <th style="text-align:right;"><span class="grid-data-length">{{data.list.length}} Einträge</span></th>
            <?php endif; ?>
      </tr>
    </thead>
    <tbody>
        <tr ng-repeat="item in data.list |  filter:searchString | orderBy:orderBy" >
            <?php foreach ($config->getPointer('list') as $item): ?>
                <? foreach($this->context->createElements($item, \admin\ngrest\render\RenderCrud::TYPE_LIST) as $element): ?>
                    <td><?= $element['html']; ?></td>
                <? endforeach; ?>
            <?php endforeach; ?>
            <?php if (count($this->context->getButtons()) > 0): ?>
            <td style="text-align:right;">
                <?php foreach ($this->context->getButtons() as $item): ?>
                <a class="waves-effect waves-light btn-flat" ng-click="<?= $item['ngClick']; ?>"><i class="<?=$item['icon']; ?>"></i><?=$item['label']; ?></a>
                <?php endforeach; ?>
            </td>
            <?php endif; ?>
        </tr>
    </tbody>
    </table>
</div>

<? if($canCreate && $config->getPointer('create')): ?>
<!-- CREATE MODAL -->
<div id="createModal" class="modal">

    <!-- MODAL HEADER -->
    <div class="modal__header">
        <div class="row">
            <div class="col s12">
                <h5>
                    <i class="mdi-action-note-add"></i> Datensatz hinzufügen
                    <i class="mdi-navigation-close right" ng-click="closeCreate()"></i>
                </h5>
            </div>
        </div>
    </div>
    <!-- /MODAL HEADER -->
    
    <form name="formCreate" role="form" ng-submit="submitCreate()">
    <!-- MODAL CONTENT -->
    <div class="modal__content">
        <?php foreach ($config->getPointer('create') as $k => $item): ?>
            <div class="row">
                <? foreach($this->context->createElements($item, \admin\ngrest\render\RenderCrud::TYPE_CREATE) as $element): ?>
                    <?= $element['html']; ?>
                <? endforeach; ?>
            </div>
        <? endforeach; ?>
        
        <div class="red lighten-2" style="color:white;" ng-show="createErrors.length">
            <ul>
                <li ng-repeat="error in createErrors" style="padding:6px;">- {{error.message}}</li>
            </ul>
        </div>
        
    </div>
    <!-- /MODAL CONTENT -->

    <!-- MODAL FOOTER -->
    <div class="modal__footer">
        <div class="row">
            <div class="col s12">
                <div class="right">
                    <button class="btn waves-effect waves-light" type="submit" ng-disabled="createForm.$invalid">
                        <i class="mdi-content-send"></i> Erstellen
                    </button>
                    <button class="btn waves-effect waves-light" type="button" ng-click="closeCreate()">
                        <i class="mdi-navigation-cancel"></i> Abbrechen
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /MODAL FOOTER -->
    </form>
    
</div>
<!-- /CREATE MODAL -->
<? endif; ?>

<? if($canUpdate && $config->getPointer('update')): ?>
<!-- UPDATE MODAL -->
<div id="updateModal" class="modal">

    <!-- MODAL HEADER -->
    <div class="modal__header">
        <div class="row">
            <div class="col s12">
                <h5>
                    <i class="mdi-editor-mode-edit"></i> Bearbeiten
                    <i class="mdi-navigation-close right" ng-click="closeUpdate()"></i>
                </h5>
            </div>
        </div>
    </div>
    <!-- /MODAL HEADER -->
    
    <form name="formUpdate" role="form" ng-submit="submitUpdate()">
    <!-- MODAL CONTENT -->
    <div class="modal__content">
        <?php foreach ($config->getPointer('update') as $k => $item): ?>
            <div class="row">
                <? foreach($this->context->createElements($item, \admin\ngrest\render\RenderCrud::TYPE_UPDATE) as $element): ?>
                    <?= $element['html']; ?>
                <? endforeach; ?>
            </div>
        <? endforeach; ?>
        
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
                        <i class="mdi-content-send"></i> Speichern
                    </button>
                    <button class="btn waves-effect waves-light" type="button" ng-click="closeUpdate()">
                        <i class="mdi-navigation-cancel"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- /MODAL FOOTER -->
    </form>
    
</div>
<!-- /UPDATE MODAL -->
<? endif; ?>

<!-- activeWindow MODAL -->
<div id="activeWindowModal" class="modal">
    <div class="modal-content" compile-html ng-bind-html="data.aw.content"></div>
</div>
</div>