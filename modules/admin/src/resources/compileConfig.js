module.exports = {

    version: "0.0.2",

    css: {
        scss: {
            config: {
                outputStyle: 'compressed' // nested, compact, expanded and compressed are available options
            }
        },
        autoprefixer: {
            enabled: true,
            config: {
                browsers: ['> 0.1%']
            }
        },
        pxToRem: {
            enabled: true,
            config: {
                rootValue: 15,
                propList: ['font', 'font-size', 'line-height', 'letter-spacing'],
                selectorBlackList: [/^html$/, /^body$/], // Ignore font-size definition on html or body
                replace: false
            }
        },
        cleanCss: {
            enabled: "dev, prep, prod",
            config: {
                compatibility: 'ie8'
            }
        }
    },

    js: {
        babeljs: {
            enabled: false,
            config: {
                minified: false
            }
        }
    },

    images: {
        imagemin: {
            enabled: true,
            config: [
                imagemin.gifsicle({interlaced: true}),
                imagemin.jpegtran({progressive: true}),
                imagemin.optipng({optimizationLevel: 5}),
                imagemin.svgo({plugins: [{removeViewBox: true}]})
            ]
        }
    },

    svg: {
        svgmin: {
            enabled: true,
            config: {
            }
        }
    },

    paths: {
        // "DESTINATION" : ['SOURCE']
        css: {
            "dist/css/": ['scss/**/*.scss']
        },
        js: {
            "dist/js/main.js": [
                "../../vendor/bower-asset/angular/angular.min.js",
                "../../vendor/bower-asset/angular-loading-bar/build/loading-bar.min.js",
                "../../vendor/bower-asset/angularjs-datepicker/dist/angular-datepicker.min.js",
                "../../vendor/bower-asset/ui-router/release/angular-ui-router.min.js",
                "../../vendor/bower-asset/ng-file-upload/ng-file-upload-shim.min.js",
                "../../vendor/bower-asset/ng-file-upload/ng-file-upload.min.js",
                "../../vendor/bower-asset/ng-flow/dist/ng-flow-standalone.min.js",
                "../../vendor/bower-asset/ng-wig/dist/ng-wig.min.js",
                "../../vendor/bower-asset/twigjs-bower/twig/twig.js",
                "../../vendor/bower-asset/angular-filter/dist/angular-filter.min.js",
                "vendorlibs/ng-colorwheel/ng-colorwheel.js",
                "../../vendor/bower-asset/bowser/src/useragent.js",
                "../../vendor/bower-asset/bowser/src/bowser.js",
                "js/dnd.js",
                "js/zaa.js",
                "js/services.js",
                "js/filters.js",
                "js/directives.js",
                "js/controllers.js"
            ],
            "dist/js/login.js": [
                "js/login.js"
            ]
        },
        images: {
            "images/": 'images/**/*'
        },
        svg: {}
    },

    // All tasks above are available (css, js, images and svg)
    combinedTasks: {
        default: [ 'css', 'js' ],
        compile: [ 'css', 'js' ],
        compress: [ 'images', 'svg' ]
    },

    watchTask: {
        'css': [ 'css' ],
        'js': [ 'js' ]
    }

};