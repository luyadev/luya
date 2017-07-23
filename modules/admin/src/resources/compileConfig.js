module.exports = {
    "configs": {
        "enableBrowserSync": false,
        "pxtorem": {
            "baseFontSize": 15,
            "selectorBlackList": [/^html$/]
        }
    },
    "source": {
        "filesToWatch": [],
        "styles": [
            "scss/**/*.scss"
        ],
        "scripts": [
        	"../../vendor/bower-asset/angular/angular.min.js",
        	"../../vendor/bower-asset/angular-loading-bar/build/loading-bar.min.js",
            "../../vendor/bower-asset/angular-slugify/angular-slugify.js",        
            "../../vendor/bower-asset/angularjs-datepicker/dist/angular-datepicker.min.js",
            "../../vendor/bower-asset/ui-router/release/angular-ui-router.min.js",
            "../../vendor/bower-asset/ng-file-upload/ng-file-upload-shim.min.js",
            "../../vendor/bower-asset/ng-file-upload/ng-file-upload.min.js",
            "vendorlibs/ng-wig/ng-wig.min.js",
            "vendorlibs/twig.js/twig.min.js",
            "vendorlibs/angular-filter/angular-filter.min.js",
            "vendorlibs/angular-flow/ng-flow-standalone.min.js",
            "vendorlibs/ng-colorwheel/ng-colorwheel.js",
            "js/dnd.js",
            "js/zaa.js",
            "js/services.js",
            "js/filters.js",
            "js/directives.js",
            "js/controllers.js"
        ]
    },
    "dest": {
        "local": {
            "styles": "dist/css/",
            "scripts": "dist/js/"
        }
    }
};
