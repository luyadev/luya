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
                rootValue: 16,
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
            enabled: true,
            config: {
                minified: true
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
            "dist/js/main.min.js": [
                "js/cmsadmin.js",
                "js/services.js"
            ]
        },
        images: {
            "img/": 'img/**/*'
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