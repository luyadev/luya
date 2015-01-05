<script>
strapCallbackUrl = '<?= $strapCallbackUrl;?>';
ngrestConfigHash = '<?= $config->getNgRestConfigHash(); ?>';
zaa.bootstrap.register('<?=$config->getNgRestConfigHash(); ?>Controller', function($scope, $controller) {
    /* extend class */
    $.extend(this, $controller('CrudController', { $scope : $scope }));
    /* local controller config */
    $scope.config.apiEndpoint = '<?=$config->getRestUrl();?>';
    $scope.config.list = <?=json_encode($crud->getFields('list'));?>;
    $scope.config.create = <?=json_encode($crud->getFields('create'));?>;
    $scope.config.update = <?=json_encode($crud->getFields('update'));?>;
    $scope.config.ngrestConfigHash = '<?= $config->getNgRestConfigHash(); ?>';
});
</script>
<div id="js-crud">
    <div ng-controller="<?=$config->getNgRestConfigHash(); ?>Controller" ng-init="init()" class="Crud">
        <div class="Crud-more Crud-more--add" ng-show="toggler.create" style="height:auto;">

            <div class="Crud-overlay">
                <span class="Crud-overlaySpinner">
                    <i class="Crud-overlayIcon fa fa-check"></i>
                </span>
            </div>

            <form class="Crud-form" ng-submit="submitCreate()" name="createForm">

                <?php foreach ($crud->create as $k => $item): ?>
                <div class="Crud-formField">
                    <?= $crud->createElement($item, $crud::TYPE_CREATE); ?>
                </div>
                <?php endforeach; ?>

                <div class="Crud-formControls">

                    <button class="Crud-button Crud-button--save" ng-disabled="createForm.$invalid" type="submit">
                        <span class="Crud-icon Crud-icon--success fa fa-floppy-o"></span>
                    </button>

                </div>
            </form>

        </div>

       <div class="Crud-toolbar">

            <button class="Crud-button Crud-button--add" type="button" ng-click="toggleCreate()">
                <span class="Crud-icon Crud-icon--success fa fa-plus"></span>
            </button>

        </div>

        	<table class="Crud-table">
    		<thead>
                <tr class="Crud-row Crud-row--header">
                <?php foreach ($crud->list as $item): ?>
                    <th class="Crud-cell"><?= $item['alias']; ?></th>
                    <?php endforeach; ?>
                    <th class="Crud-cell Crud-cell--center">Actions</th>
                </tr>
            </thead>
            <tbody>

                <tr class="Crud-row" ng-repeat="item in data.list | filter:search">
                    <?php foreach ($crud->list as $item): ?>
                    <td class="Crud-cell"><?= $crud->createElement($item, $crud::TYPE_LIST); ?></td>
                    <?php endforeach; ?>
                    <td class="Crud-cell Crud-cell--center Crud-cell--noWrap">
                        <button type="button" ng-click="toggleUpdate(item.<?= $config->getRestPrimaryKey(); ?>, $event)" class="btn btn-primary">Bearbeiten</button>
                        <?php foreach ($crud->getStraps() as $item): ?>
                        <button type="button" ng-click="getStrap('<?= $item['strapHash']; ?>', item.<?= $config->getRestPrimaryKey();?>, $event)"><?=$item['alias']; ?></button>
                        <?php endforeach; ?>
                    </td>
                </tr>

                <!--  EDIT -->
                <tr class="Crud-more">
                    <td colspan="100">
                        <div class="Crud-editWrapper" ng-show="toggler.update" style="height:auto;">
                            <div class="Crud-overlay">
                                <span class="Crud-overlaySpinner">
                                    <i class="Crud-overlayIcon fa fa-check"></i>
                                </span>
                            </div>

                            <form ng-submit="submitUpdate()" name="updateForm">
                        	<table class="table table-bordered">
                        	<?php foreach ($crud->update as $k => $item): ?>
                    		<tr>
                    		    <td><?= $item['alias'] ?></td>
                    		    <td><?= $crud->createElement($item, $crud::TYPE_UPDATE); ?></td>
                    		</tr>
                    		<?php endforeach; ?>
                        	</table>
                        	<button type="submit" class="btn btn-default" ng-disabled="updateForm.$invalid">Speichern</button>
                        	</form>
                        </div>
                        <div class="Crud-editWrapper" ng-show="toggler.strap" style="height:auto;">
                            <div ng-bind-html="data.strap.content"></div>
                        </div>
                    </td>
                </tr>
                <!-- /EDIT -->

            </tbody>
            </table>


        <button ng-click="debug()">Debug (console.log)</button>
    </div>
</div>
