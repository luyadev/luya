
zaa.controller("UploadController", function($scope) {

	$scope.bildId = 0;
	
	$scope.save = function()
	{
		console.log('save', $scope.bildId);
	}
	
})

zaa.directive('fileModel', ['$parse', function ($parse) {
    return {
        restrict: 'A',
        link: function(scope, element, attrs) {
            var model = $parse(attrs.fileModel);
            var modelSetter = model.assign;
            
            element.bind('change', function(){
                scope.$apply(function(){
                    modelSetter(scope, element[0].files[0]);
                });
            });
        }
    };
}]);

zaa.directive('storageFileUpload', function() {
	return {
		restrict : 'E',
		scope : {
			ngModel : '='
		},
		controller : function($scope, $http) {
			$scope.push = function()
			{
				var fd = new FormData();
		        fd.append('file', $scope.myFile);
		        $http.post('admin/api-admin-storage/files-upload', fd, {
		            transformRequest: angular.identity,
		            headers: {'Content-Type': undefined}
		        })
		        .success(function(r){
		        	if (!r[$scope.myFile.name]['error']) {
		        		$scope.ngModel = r[$scope.myFile.name]['id'];
		        	}
		        	
		        })
		        .error(function(r){
		        	console.log(r);
		        });
				
			}
		},
		template : function()
		{
			return '<div style="Border:1px solid red;"><table><tr><td>Datei Auswahl:</td><td><input file-model="myFile" type="file" /></td><td><button ng-click="push()" type="button">Datei Hochladen</button></td></tr></table></div>';
		}
	}
});

zaa.directive('storageImageUpload', function() {
	return {
		restrict : 'E',
		scope : {
			ngModel : '='
		},
		controller : function($scope, $http) {
			
			$scope.push2 = function() {
				$http.post('admin/api-admin-storage/image-upload', $.param({ fileId : $scope.test, filterId : $scope.filterId }), {
		        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		        }).success(function(success) {
					$scope.ngModel = success.id;
				}).error(function(error) {
					console.log('err', error);
				});
			}
			
		},
		template : function () {
			return '<table><tr><td>Filter:</td><td><input type="text" name="filterId" ng-model="filterId" value="0" /></td></tr><tr><td>Datei:</td><td><storage-file-upload ng-model="test"></storage-file-upload></td></tr><tr><td></td><td><button ng-click="push2()" type="button">Bild &amp; Filter Anwenden</button></td></tr></table>';
		}
	}
});