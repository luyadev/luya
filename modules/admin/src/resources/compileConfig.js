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
            "bowervendor/angular/angular.min.js",
            "bowervendor/angular-chosen/angular-chosen.min.js",
            "bowervendor/angular-datepicker/angular-datepicker.min.js",
            "bowervendor/angular-dragdrop/src/angular-dragdrop.min.js",
            "bowervendor/angular-loading-bar/loading-bar.min.js",
            "bowervendor/angular-slugify/angular-slugify.js",
            "bowervendor/angular-ui-router/release/angular-ui-router.min.js",
            "bowervendor/jquery-ui/jquery-ui.min.js",
            "bowervendor/ng-file-upload/ng-file-upload.min.js",
            "bowervendor/ng-file-upload/ng-file-upload-shim.min.js",
            "bowervendor/ng-wig/ng-wig.min.js",
            "bowervendor/twig.js/twig.min.js",
            "bowervendor/angular-filter.min.js",
            "js/libs/*.js",
            "js/zaa.js",
            "js/services.js",
            "js/directives.js",
            "js/controller.js"
        ]
    },

    "dest": {
        "local": {
            "styles": "dist/css/",
            "scripts": "dist/js/"
        },
        "prod": {
            "styles": "dist/css/",
            "scripts": "dist/js/"
        }
    }
};