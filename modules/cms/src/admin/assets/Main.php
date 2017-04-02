<?php

namespace luya\cms\admin\assets;

class Main extends \yii\web\AssetBundle
{
    public $sourcePath = '@cmsadmin/resources';

    public $js = [
        'dist/js/main.min.js'
    ];

    public $css = [
        'dist/css/cmsadmin.css',
        'dist/css/cmsadmin-block-styles.css',
    ];

    public $depends = [
        'luya\admin\assets\Main',
    ];
}
