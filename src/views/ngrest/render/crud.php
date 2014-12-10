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
<div ng-controller="<?=$config->getNgRestConfigHash(); ?>Controller" ng-init="init()">
    <crud>
    
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
    
        <crud-list>
            <div class="well">
                <input type="text" placeholder="Suchbegriff eingeben" ng-model="search" class="form-control" />
            </div>
        
            <table class="table table-bordered">
            <thead>
            <tr>
                <? foreach($crud->list as $item): ?>
                <th><?= $item['alias']; ?></th>
                <? endforeach; ?>
                <th>Actions</th>
            </tr>
            </thead>
            <tr ng-repeat="item in data.list | filter:search">
                <? foreach($crud->list as $item): ?>
                <td><?= $crud->createElement($item, $crud::TYPE_LIST); ?></td>
                <? endforeach; ?>
                <td>
                    <button type="button" ng-click="toggleUpdate(item.<?= $config->getRestPrimaryKey(); ?>)" class="btn btn-primary">Bearbeiten</button>
                    <? foreach($crud->getStraps() as $item): ?>
                    <button type="button" ng-click="getStrap('<?= $item['strapHash']; ?>', item.<?= $config->getRestPrimaryKey();?>)"><?=$item['alias']; ?></button>
                    <? endforeach; ?>
                </td>
            </tr>
            </table>
        </crud-list>
        
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
    </crud>
    <hr />
    <button ng-click="debug()">Debug (console.log)</button>
</div>
