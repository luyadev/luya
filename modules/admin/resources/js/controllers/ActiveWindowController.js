zaa.controller("ActiveWindowGalleryController", function($scope, $http, Upload, $timeout) {
	
	$scope.crud = $scope.$parent; // {{ data.aw.itemId }}
	
	/* UPLOAD */
	$scope.uploading = false;
	
	$scope.serverProcessing = false;
	
	$scope.uploadResults = null;
	
	$scope.$watch('uploadingfiles', function (uploadingfiles) {
        if (uploadingfiles != null) {
			$scope.uploadResults = 0;
			$scope.uploading = true;
            for (var i = 0; i < uploadingfiles.length; i++) {
                $scope.errorMsg = null;
                (function (uploadingfiles) {
                	$scope.uploadUsingUpload(uploadingfiles);
                })(uploadingfiles[i]);
            }
        }
    });

	$scope.$watch('uploadResults', function(n, o) {
		if ($scope.uploadingfiles != null) {
			if (n == $scope.uploadingfiles.length) {
				$scope.serverProcessing = true;
				$scope.loadImages();
			}
		}
	})
	
	$scope.uploadUsingUpload = function(file) {
        file.upload = Upload.upload({
        	url: $scope.crud.getActiveWindowCallbackUrl('upload'),
            file: file
        });

        file.upload.then(function (response) {
            $timeout(function () {
            	$scope.uploadResults++;
            	file.processed = true;
                file.result = response.data;
            });
        }, function (response) {
            if (response.status > 0)
                $scope.errorMsg = response.status + ': ' + response.data;
        });

        file.upload.progress(function (evt) {
        	file.processed = false;
            // Math.min is to fix IE which reports 200% sometimes
            file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
        });
    }
	/* \UPLOAD */
	
	$scope.images = [];
	
	$scope.loadImages = function() {
		$http.get($scope.crud.getActiveWindowCallbackUrl('images')).success(function(response) {
			$scope.images = response;
		})
	}
	
	$scope.$watch(function() { return $scope.data.aw.itemId }, function(n, o) {
		$scope.loadImages();
	});
	
});

zaa.controller("ActiveWindowChangePassword", function($scope) {
	
	$scope.crud = $scope.$parent;
	
	$scope.init = function() {
		$scope.error = false;
		$scope.submitted = false;
		$scope.transport = [];
		$scope.newpass = null;
		$scope.newpasswd = null;
	}
	
	$scope.$watch(function() { return $scope.crud.data.aw.itemId }, function(n, o) {
		$scope.init();
	})
	
	$scope.submit = function() {
		$scope.crud.sendActiveWindowCallback('save', {'newpass' : $scope.newpass, 'newpasswd' : $scope.newpasswd}).then(function(response) {
			$scope.submitted = true;
			$scope.error = response.data.error;
			$scope.transport = response.data.transport;
		})
	}
});