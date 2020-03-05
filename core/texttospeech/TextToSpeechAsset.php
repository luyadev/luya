<?php

namespace luya\texttospeech;

use luya\web\Asset;

class TextToSpeechAsset extends Asset
{
    /**
     * @var string The path to the source files of the asset.
     */
    public $sourcePath = '@luya/resources/texttospeech';

    /**
     * @var array An array with all javascript files for this asset located in the source path folder.
     */
    public $js = [
        YII_ENV_PROD ? 'texttospeech.js' : 'texttospeech.src.js',
    ];

    /**
     * @var array An array with assets this asset depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}