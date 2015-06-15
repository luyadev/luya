<script>
activeWindowCallbackUrl = '<?= $activeWindowCallbackUrl;?>';
ngrestConfigHash = '<?= $config->getNgRestConfigHash(); ?>';
zaa.bootstrap.register('<?=$config->getNgRestConfigHash(); ?>', function($scope, $controller) {
    /* extend class */
    $.extend(this, $controller('CrudController', { $scope : $scope }));
    /* local controller config */
    $scope.config.apiListQueryString = '<?= $crud->apiQueryString('list'); ?>';
    $scope.config.apiUpdateQueryString = '<?= $crud->apiQueryString('update'); ?>';
    $scope.config.apiEndpoint = '<?=$config->getRestUrl();?>';
    $scope.config.list = <?=json_encode($crud->getFields('list'));?>;
    $scope.config.create = <?=json_encode($crud->getFields('create'));?>;
    $scope.config.update = <?=json_encode($crud->getFields('update'));?>;
    $scope.config.ngrestConfigHash = '<?= $config->getNgRestConfigHash(); ?>';
    $scope.config.activeWindowCallbackUrl = '<?= $activeWindowCallbackUrl;?>';
});
</script>

<div ng-controller="<?=$config->getNgRestConfigHash(); ?>" ng-init="init()">
<a ng-show="config.create.length" class="btn-floating btn-large waves-effect waves-light right red" style="margin:20px;" ng-click="openCreate()"><i class="mdi-content-add"></i></a>

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
    <table class="striped hoverable responsive-table">
    <thead>
        <tr>
            <?php foreach ($crud->list as $item): ?>
                <th><?= $item['alias']; ?> <i ng-click="changeOrder('<?= $item['name']; ?>', '+')" class="mdi-hardware-keyboard-arrow-up grid-sort-btn"></i> <i ng-click="changeOrder('<?= $item['name']; ?>', '-')" class="mdi-hardware-keyboard-arrow-down grid-sort-btn"></i></th>
            <?php endforeach; ?>
            <?php if (count($crud->getButtons()) > 0): ?>
                <th style="text-align:right;"><span class="grid-data-length">{{data.list.length}} Einträge</span></th>
            <?php endif; ?>
      </tr>
    </thead>
    <tbody>
        <tr ng-repeat="item in data.list |  filter:searchString | orderBy:orderBy" >
            <?php foreach ($crud->list as $item): ?>
                <? foreach($crud->createElements($item, $crud::TYPE_LIST) as $element): ?>
                    <td><?= $element['html']; ?></td>
                <? endforeach; ?>
            <?php endforeach; ?>
            <?php if (count($crud->getButtons()) > 0): ?>
            <td style="text-align:right;">
                <?php foreach ($crud->getButtons() as $item): ?>
                <a class="waves-effect waves-light btn-flat" ng-click="<?= $item['ngClick']; ?>"><i class="<?=$item['icon']; ?>"></i><?=$item['label']; ?></a>
                <?php endforeach; ?>
            </td>
            <?php endif; ?>
        </tr>
    </tbody>
    </table>
</div>

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
    
    <form role="form" ng-submit="submitCreate()">
    <!-- MODAL CONTENT -->
    <div class="modal__content">
        <?php foreach ($crud->create as $k => $item): ?>
            <div class="row">
                <? foreach($crud->createElements($item, $crud::TYPE_CREATE) as $element): ?>
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
    
    <form role="form" ng-submit="submitUpdate()">
    <!-- MODAL CONTENT -->
    <div class="modal__content">
        <?php foreach ($crud->update as $k => $item): ?>
            <div class="row">
                <? foreach($crud->createElements($item, $crud::TYPE_UPDATE) as $element): ?>
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


<!-- activeWindow MODAL -->
<div id="activeWindowModal" class="modal">
    <div class="modal-content" compile-html ng-bind-html="data.aw.content"></div>
</div>
</div>