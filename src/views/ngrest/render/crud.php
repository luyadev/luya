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
<div ng-controller="<?=$config->getNgRestConfigHash(); ?>Controller" ng-init="init()" class="Crud">
   <div class="Crud-toolbar">

        <button class="Crud-button Crud-button--add" type="button" ng-click="toggleCreate()">
            <span class="Crud-icon Crud-icon--success fa fa-plus"></span>
        </button>

    </div>
    
    	<crud-create>
    	    <form ng-submit="submitCreate()" name="createForm">
        		<table class="table table-bordered">
        		<? foreach($crud->create as $k => $item): ?>
        		<tr>
        		    <td><?= $item['alias'] ?> </td>
        		    <td><?= $crud->createElement($item, $crud::TYPE_CREATE); ?></td>
        		</tr>
        		<? endforeach; ?>
        		</table>
        		<button type="submit" class="btn btn-default" ng-disabled="createForm.$invalid">Speichern</button>
    		</form>
    	</crud-create>
    
    
    	<table class="Crud-table">
		<thead>
            <tr class="Crud-row Crud-row--header">
            <? foreach($crud->list as $item): ?>
                <th class="Crud-cell"><?= $item['alias']; ?></th>
                <? endforeach; ?>
                <th class="Crud-cell Crud-cell--center">Actions</th>
            </tr>
        </thead>
        <tbody>
    
            <tr class="Crud-row" ng-repeat="item in data.list | filter:search">
                <? foreach($crud->list as $item): ?>
                <td class="Crud-cell"><?= $crud->createElement($item, $crud::TYPE_LIST); ?></td>
                <? endforeach; ?>
                <td class="Crud-cell Crud-cell--center Crud-cell--noWrap">
                    <button type="button" ng-click="toggleUpdate(item.<?= $config->getRestPrimaryKey(); ?>)" class="btn btn-primary">Bearbeiten</button>
                    <? foreach($crud->getStraps() as $item): ?>
                    <button type="button" ng-click="getStrap('<?= $item['strapHash']; ?>', item.<?= $config->getRestPrimaryKey();?>)"><?=$item['alias']; ?></button>
                    <? endforeach; ?>
                </td>
            </tr>
        
        </tbody>
        </table>
        
        <crud-update>
            <form ng-submit="submitUpdate()" name="updateForm">
        	<table class="table table-bordered">
        	<? foreach($crud->update as $k => $item): ?>
    		<tr>
    		    <td><?= $item['alias'] ?></td>
    		    <td><?= $crud->createElement($item, $crud::TYPE_UPDATE); ?></td>
    		</tr>
    		<? endforeach; ?>
        	</table>
        	<button type="submit" class="btn btn-default" ng-disabled="updateForm.$invalid">Speichern</button>
        	</form>
        </crud-update>
        
        <crud-strap></crud-strap>
    <button ng-click="debug()">Debug (console.log)</button>
</div>
