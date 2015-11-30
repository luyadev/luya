<?php

namespace admin\assets;

class Bower extends \luya\web\Asset
{
    public $sourcePath = '@bower';

    public $js = [
        'angular/angular.min.js',
        'angular-i18n/angular-locale_de-ch.js',
        'angular-resource/angular-resource.min.js',
        'angular-ui-router/release/angular-ui-router.min.js',
        'angular-dragdrop/src/angular-dragdrop.min.js',
        'angular-loading-bar/build/loading-bar.min.js',
        'angular-slugify/angular-slugify.js',
        'twig.js/twig.min.js',
        'ng-wig/dist/ng-wig.min.js',

        'ng-file-upload/ng-file-upload.min.js',
        'ng-file-upload/ng-file-upload-shim.min.js',

        // ace
        // 'ace-builds/src-min-noconflict/ace.js', // "bower-asset/angular-ui-ace" : "0.*@stable",
        // 'angular-ui-ace/ui-ace.js', // "bower-asset/ace-builds" : "1.1.8@stable",
    ];

    public $css = [
        'angular-loading-bar/build/loading-bar.min.css',
    ];
}
