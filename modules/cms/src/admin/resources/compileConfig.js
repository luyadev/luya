module.exports = {
    "configs": {
        "enableBrowserSync": false,
        "pxtorem": {
            "baseFontSize": 16,
            "selectorBlackList": [/^html$/]
        }
    },

    "source": {
        "filesToWatch": [],
        "styles": [
            "scss/**/*.scss"
        ],
        "scripts": [
            "js/cmsadmin.js",
            "js/services.js"
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