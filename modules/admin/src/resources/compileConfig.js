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
            "vendor/angular/angular.min.js",
            "vendor/angular-chosen/angular-chosen.min.js",
            "vendor/angular-datepicker/angular-datepicker.min.js",
            "vendor/angular-dragdrop/angular-dragdrop.min.js",
            "vendor/angular-loading-bar/loading-bar.min.js",
            "vendor/angular-slugify/angular-slugify.js",
            "vendor/angular-ui-router/angular-ui-router.min.js",
            "vendor/jquery-ui/jquery-ui.min.js",
            "vendor/ng-file-upload/ng-file-upload.js",
            "vendor/ng-file-upload/ng-file-upload-shim.js",
            "vendor/ng-wig/ng-wig.min.js",
            "vendor/twig.js/twig.min.js",
            "vendor/angular-filter/angular-filter.min.js",
            "vendor/angular-flow/ng-flow-standalone.min.js",
            "js/zaa.js",
            "js/services.js",
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
