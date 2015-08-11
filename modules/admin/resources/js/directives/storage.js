zaa.factory('FileListeService', function($http, $q) {
	var service = [];
	
	service.data = [];
	
	service.get = function(folderId, forceReload) {
		return $q(function(resolve, reject) {
			if (folderId in service.data && forceReload !== true) {
				resolve(service.data[folderId]);
			} else {
				$http.get('admin/api-admin-storage/get-files', { params : { folderId : folderId } }).success(function(response) {
					service.data[folderId] = response;
					resolve(response);
				});
			}
		});
		
	}
	
	return service;
});

zaa.factory('FileIdService', function($http, $q) {
	var service = [];
	
	service.data = [];
	
	service.get = function(fileId, forceReload) {
		return $q(function(resolve, reject) {
			if (fileId in service.data && forceReload !== true) {
				//console.log('request existing fileId', fileId);
				resolve(service.data[fileId]);
			} else {
				$http.get('admin/api-admin-storage/file-path', { params: { fileId : fileId } }).success(function(response) {
					service.data[fileId] = response;
					resolve(response);
				}).error(function(response) {
					console.log('Error while loading fileID ' + fileId, response);
				})
			}
		});
	}
	
	return service;
});

zaa.factory('ImageIdService', function($http, $q) {
	var service = [];
	
	service.data = [];
	
	service.get = function(imageId, forceReload) {
		return $q(function(resolve, reject) {
			if (imageId in service.data && forceReload !== true) {
				//console.log('request existing imageId', imageId);
				resolve(service.data[imageId]);
			} else {
				$http.get('admin/api-admin-storage/image-path', { params: { imageId : imageId } }).success(function(response) {
					service.data[imageId] = response;
					//console.log('request NOT EXISTING imageId', imageId);
					resolve(response);
				}).error(function(response) {
					console.log('Error while loading imageId ' + imageId, response);
				})
			}
		});
	}
	
	return service;
});

zaa.factory('FilemanagerFolderService', function() {
	var service = [];
	
	service.folderId = 0;
	
	service.set = function(id) {
		service.folderId = id;
	}
	
	service.get = function() {
		return service.folderId;
	}
	
	return service;
});

zaa.factory('FilemanagerFolderListService', function($http, $q) {
	var service = [];
	
	service.data = null;
	
	service.get = function(forceReload) {
		return $q(function(resolve, reject) {
			if (service.data === null || forceReload === true) {
				$http.get('admin/api-admin-storage/get-folders').success(function(response) {
					service.data = response;
					resolve(response);
				}).error(function(response) {
					reject(response);
				});
			} else {
				resolve(service.data);
			}
			
		});
	}
	
	return service;
});

zaa.directive('storageFileUpload', function($http, FileIdService) {
	return {
		restrict : 'E',
		scope : {
			ngModel : '='
		},
		link : function(scope) {
			
			scope.modal = true;
			scope.fileinfo = null;
			
			scope.select = function(fileId) {
				scope.toggleModal();
				scope.ngModel = fileId;
			}
			
			scope.toggleModal = function() {
				scope.modal = !scope.modal;
			}
			
			scope.$watch(function() { return scope.ngModel }, function(n, o) {
				if (n != 0 && n != null && n !== undefined) {
					FileIdService.get(n).then(function(response) {
						scope.fileinfo = response;
					});
				}
			});
		},
		templateUrl : 'storageFileUpload'
	}
});

zaa.directive('storageImageUpload', function($http, ApiAdminFilter, ImageIdService) {
	return {
		restrict : 'E',
		scope : {
			ngModel : '=',
			options : '=',
		},
		link : function(scope) {

			scope.noFilters = function() {
				if (scope.options) {
					return scope.options.no_filter;
				}
			}
			
            scope.imageLoading = false;
			scope.fileId = 0;
			scope.filterId = 0;
			scope.imageinfo = null;
			
			scope.filters = ApiAdminFilter.query();
			scope.originalFileIsRemoved = false;
			
			scope.lastapplyFileId = 0;
			scope.lastapplyFilterId = 0;
			
			scope.filterApply = function() {
				
				if (scope.fileId == 0) {
					alert('Sie müssen zuerst eine Datei auswählen um den Filter anzuwenden.');
					return;
				}
				
				if (scope.lastapplyFileId == scope.fileId && scope.lastapplyFilterId == scope.filterId) {
					return;
				}
				
				scope.originalFileIsRemoved = false;
				
                scope.imageLoading = true;

                scope.lastapplyFileId = scope.fileId;
                scope.lastapplyFilterId = scope.filterId;
                
				$http.post('admin/api-admin-storage/image-upload', $.param({ fileId : scope.fileId, filterId : scope.filterId }), {
		        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		        }).success(function(success) {
		        	if (!success) {
		        		alert('Beim Anwenden des Filters auf die Datei ist ein Fehler Passiert');
		        	} else {
		        		if (success.image.file_is_deleted == 1) {
		        			scope.originalFileIsRemoved = true;
		        		}
		        		scope.ngModel = success.id;
		        	}

                    scope.imageLoading = false;
				}).error(function(error) {
					alert('Beim Anwenden des Filters auf die Datei ist ein Fehler Passiert');
                    scope.imageLoading = false;
				});
			};
			
			scope.$watch(function() { return scope.filterId }, function(n, o) {
				if (n != null && n !== undefined && scope.fileId !== 0 && n !== o) {
					scope.filterApply();
				}
			});
			
			scope.$watch(function() { return scope.fileId }, function(n, o) {
				if (n != 0 && n !== undefined && n !== o) {
					scope.filterApply();
				}
			});
			
			scope.$watch(function() { return scope.ngModel }, function(n, o) {
				if (n != 0 && n != null && n !== undefined) {
					ImageIdService.get(n).then(function(response) {
						scope.imageinfo = response;
						scope.filterId = response.filter_id;
						scope.fileId = response.file_id;
					});
				}
			})
		},
		templateUrl : 'storageImageUpload'
	}
});




/**
 * FILE MANAGER DIR
 */
zaa.directive("storageFileManager", function(FileListeService, Upload, FilemanagerFolderService, FilemanagerFolderListService) {
	return {
		restrict : 'E',
		transclude : false,
		scope : {
			allowSelection : '@selection'
		},
		transclude : false,
		controller : function($scope, $http, $timeout) {
			
			$scope.showFolderForm = false;
			
			$scope.files = [];
			
			$scope.folders = [];
			
			$scope.selectedFiles = [];
			
			$scope.uploading = false;
			
			$scope.showFoldersToMove = false;
			
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
						$scope.getFiles($scope.currentFolderId, true);
					}
				}
			})
			
			$scope.uploadUsingUpload = function(file) {
		        file.upload = Upload.upload({
		        	url: 'admin/api-admin-storage/files-upload',
                    fields: {'folderId': $scope.currentFolderId},
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
			
			$scope.hasSelection = function() {
				if ($scope.selectedFiles.length > 0) {
					return true;
				}
				
				return false;
			}
			
			$scope.moveFilesTo = function(folder) {
				$http.post('admin/api-admin-storage/files-move', $.param({'fileIds' : $scope.selectedFiles, 'toFolderId' : folder.id}), {
		        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		        }).success(function(transport) {
		        	$scope.showFoldersToMove = false;
					$scope.clearSelection();
					
					$scope.getFiles($scope.currentFolderId, true);
					
					FileListeService.get(folder.id, true).then(function(r) {
					});
					
		        });
			}
			
			$scope.updateFolder = function(folder) {
				$http.post('admin/api-admin-storage/folder-update?folderId=' + folder.data.id, $.param({ name : folder.data.name }), {
		        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		        }).success(function(transport) {
		        	folder.edit = false;
		        });
			}
			
			$scope.clearSelection = function() {
				$scope.selectedFiles = [];
			}
			
			$scope.toggleSelection = function(file) {
				if ($scope.allowSelection == 'true') {
					$scope.selectFile(file);
					return;
				}

				var i = $scope.selectedFiles.indexOf(file.id);
				if (i > -1) {
					$scope.selectedFiles.splice(i, 1);
				} else {
					$scope.selectedFiles.push(file.id);
				}
			}

			$scope.toggleSelectionAll = function() {
				if ($scope.allowSelection == 'false') {
					if ($scope.selectedFiles.length > 0 && $scope.selectedFiles.length != $scope.files.length) {
						$scope.selectedFiles = [];
					}

					for (var i = $scope.files.length - 1; i >= 0; i--) {
						$scope.toggleSelection($scope.files[i]);
					};
				}
			}
			
			$scope.inSelection = function(file) {
				response = $scope.selectedFiles.indexOf(file.id);
				
				if (response != -1) {
					return true;
				}
				
				return false;
			}
			
			$scope.removeSelectedItems = function() {
				cfm = confirm("Möchten Sie diese Datei wirklich entfernen?");
				if (cfm) {
					$http.post('admin/api-admin-storage/files-delete', $.param({'ids' : $scope.selectedFiles}), {
			        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
			        }).success(function(transport) {
			        	if (transport) {
			        		$scope.getFiles(FilemanagerFolderService.get(), true);
			        		$scope.clearSelection();
			        	}
			        });
				}
			}
			
			$scope.createNewFolder = function(newFolderName) {
				$http.post('admin/api-admin-storage/folder-create', $.param({ folderName : newFolderName , parentFolderId : $scope.currentFolderId }), {
		        	headers : {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'}
		        }).success(function(transport) {
		        	if (transport) {
		        		$scope.showFolderForm = false;
		        		$scope.newFolderName = '';
		        		$http.get('admin/api-admin-storage/get-folders').success(function(response) {
		        			$scope.folders = response;
		        		});
		        	}
		        });
			}
			
			$scope.folderFormToggler = function() {
				$scope.showFolderForm = !$scope.showFolderForm;
			}
			
			$scope.selectFile = function(file) {
				$scope.$parent.select(file.id);
			}

            $scope.toggleModal = function() {
                $scope.$parent.toggleModal();
            }
			
			$scope.loadFolder = function(folderId) {
				$scope.showFoldersToMove = false;
				$scope.clearSelection();
				FilemanagerFolderService.set(folderId);
				$scope.currentFolderId = folderId;
				$scope.getFiles(folderId);
			}
			
			$scope.getFiles = function(folderId, forceReload) {
				FileListeService.get(folderId, forceReload).then(function(r) {
					$scope.files = r;
					$scope.uploading = false;
					$scope.serverProcessing = false;
				});
			}
			
			$timeout(function() {
				FilemanagerFolderListService.get().then(function(r) {
					$scope.folders = r;
	    			$scope.getFiles(FilemanagerFolderService.get());
	    			$scope.currentFolderId = FilemanagerFolderService.get();
				});
			}, 100);
		},
		templateUrl : 'storageFileManager'
	}
})