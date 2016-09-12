<?php

namespace luya\admin\assets;

use Yii;

/**
 * BowerVendor Asset contains all files from old bower-asset depencies.
 *
 * Now the bower asset files are directly downloaded by the luya team and stored in the resources/vendor folder
 * base on the following composer.json data for fxp asset plugin:
 *
 * ```
 *   "bower-asset/jquery-ui" : "1.11.4",
 *   "bower-asset/angular" : "1.4.8",
 *   "bower-asset/angular-i18n" : "1.4.8",
 *   "bower-asset/angular-resource": "1.4.8",
 *   "bower-asset/angular-ui-router" : "0.2.15",
 *   "bower-asset/angular-loading-bar" : "0.8.0",
 *   "bower-asset/angular-dragdrop" : "1.0.13",
 *   "bower-asset/angular-slugify" : "1.0.1",
 *   "bower-asset/twig.js" : "0.8.6",
 *   "bower-asset/ng-file-upload" : "11.0.2",
 *   "bower-asset/ng-wig" : "2.3.3",
 * ```
 *
 * The query file is no used as we do use the yii\web\JqueryAsset
 *
 * ```
 *" bower-asset/jquery" : "2.2.0",
 * ```
 * This makes the speed for downloading and installing luya much faster. There is now also a good way to compress all those
 * files into a single file which reduces the number of admin requests on load (TBD).
 *
 * @author nadar
 * @since 1.0.0-beta4
 */
class BowerVendor extends \luya\web\Asset
{
    public $sourcePath = '@admin/resources/bowervendor';

    public $css = [
        // 'angular-datepicker/datepicker.min.css', // Moved to scss
        'angular-chosen/chosen.min.css',
    ];
    
    public function init()
    {
        parent::init();
        
        // as params are not allowed inside array properties we have located the filling of the $js param into the initalizer.
        $this->js = [
            // jquery ui
            'jquery-ui/jquery-ui.min.js',
            // angular files (official repo)
            'angular/angular.min.js',
            'angular-i18n/angular-locale_'.Yii::$app->luyaLanguage.'.js',
            //'angular-resource/angular-resource.min.js',
            // ui router
            'angular-ui-router/release/angular-ui-router.min.js',
            // drag&drop (replace with native html5)
            'angular-dragdrop/src/angular-dragdrop.min.js',
            // loadingbar
            'angular-loading-bar/build/loading-bar.min.js',
            // slugify
            'angular-slugify/angular-slugify.js',
            // twig.js
            'twig.js/twig.min.js',
            // ng-wig WYSIWYG editor
            'ng-wig/dist/ng-wig.min.js',
            // file upload
            'ng-file-upload/ng-file-upload.min.js',
            'ng-file-upload/ng-file-upload-shim.min.js',
    
            'angular-filter.min.js',
            'angular-datepicker/datepicker.min.js',
            'angular-chosen/angular-chosen.min.js',
        ];
    }
}
