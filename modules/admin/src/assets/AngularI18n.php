<?php

namespace luya\admin\assets;

use Yii;

/**
 * BowerVendor Asset contains all files from old bower-asset depencies.
 *
 * Now the bower asset files are directly downloaded by the luya team and stored in the resources/vendor folder
 * base on the following composer.json data for fxp asset plugin:
 *
 * ```json
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
 * ```json
 * "bower-asset/jquery" : "2.2.0",
 * ```
 *
 * This makes the speed for downloading and installing luya much faster. There is now also a good way to compress all those
 * files into a single file which reduces the number of admin requests on load (TBD).
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0-beta4
 */
class AngularI18n extends \luya\web\Asset
{
    /**
     * @var string The path to the folder where the files of this asset are located.
     */
    public $sourcePath = '@admin/resources/angular-i18n';

    /**
     * As params are not allowed inside array properties we have located the filling of the $js param into the initalizer.
     *
     * @see \yii\web\AssetBundle::init()
     */
    public function init()
    {
        parent::init();
        
        $lang = Yii::$app->luyaLanguage;
        
        if (!Yii::$app->adminuser->isGuest) {
            $lang = Yii::$app->adminuser->identity->setting->get('luyadminlanguage', Yii::$app->luyaLanguage);
        }
        
        $this->js = [
            'angular-locale_'.$lang.'.js',
        ];
    }

    public $depends = [
        'luya\admin\assets\Main',
    ];
}
