(function() {
    "use strict";
    
    zaa.filter("filemanagerdirsfilter", function() {
        return function(input, parentFolderId) {
            var result = [];
            angular.forEach(input, function(value, key) {
                if (value.parentId == parentFolderId) {
                    result.push(value);
                }
            });

            return result;
        };
    });

    zaa.filter("findthumbnail", function() {
    	return function(input, fileId, thumbnailFilterId) {
    		var result = false;
    		angular.forEach(input, function(value, key) {
    			if (!result) {
	    			if (value.fileId == fileId && value.filterId == thumbnailFilterId) {
	    				result = value;
	    			}
    			}
    		})

    		return result;
    	}
    });

    zaa.filter("findidfilter", function() {
        return function(input, id) {

            var result = false;

            angular.forEach(input, function(value, key) {
                if (value.id == id) {
                    result = value;
                }
            });

            return result;
        }
    });

    zaa.filter("filemanagerfilesfilter", function() {
        return function(input, folderId, onlyImages) {

            var result = [];

            angular.forEach(input, function(data) {
                if (onlyImages) {
                    if (data.folderId == folderId && data.isImage == true) {
                        result.push(data);
                    }
                } else {
                    if (data.folderId == folderId) {
                        result.push(data);
                    }
                }
            });

            return result;
        };
    });
    
    zaa.filter('trustAsUnsafe', function ($sce) {
        return function (val, enabled) {
            return $sce.trustAsHtml(val);
        };
    });
    
    zaa.filter('srcbox', function () {
        return function (input, search) {
            if (!input) return input;
            if (!search) return input;
            var expected = ('' + search).toLowerCase();
            var result = {};
            angular.forEach(input, function (value, key) {
                angular.forEach(value, function (kv, kk) {
                    var actual = ('' + kv).toLowerCase();
                    if (actual.indexOf(expected) !== -1) {
                        result[key] = value;
                    }
                });
            });
            return result;
        }
    });

    zaa.filter('trustAsResourceUrl', function ($sce) {
        return function (val, enabled) {
            if (!enabled) {
                return null;
            }
            return $sce.trustAsResourceUrl(val);
        };
    });

    zaa.filter('truncateMiddle', function () {
        return function (val, length, placeholder) {
            if(!length) {
                length = 30;
            }
            if(!placeholder) {
                placeholder = '...';
            }

            if(val.length <= length) {
                return val;
            }

            var targetLength = length - placeholder.length;
            var partLength = targetLength / 2;

            return (val.substring(0, partLength)) + placeholder + val.substring(val.length - partLength, val.length);
        };
    });
    
})();