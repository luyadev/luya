<?php

namespace luya\admin\assets;

use Yii;

/**
 * AngularI18n Asset includes the angular locale file current language.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
        
        $lang = Yii::$app->adminuser->getInterfaceLanguage();
        
        $this->js = [
            'angular-locale_'.$lang.'.js',
        ];
    }

    public $depends = [
        'luya\admin\assets\Main',
    ];
}
