
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

zaa.directive('storageUploadForm', function() {
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
		        	console.log(r);
		        })
		        .error(function(r){
		        	conosole.log(r);
		        });
				
			}
		},
		template : function()
		{
			return '<input file-model="myFile" type="file" /><button ng-click="push()" type="button">button</button>';
		}
	}
});

zaa.directive('storageFilemanager', function() {
	
});