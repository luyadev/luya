<?php

namespace luya\texttospeech;

use luya\web\Asset;

/**
 * Text to Speech Asset.
 *
 * @author Martin Petrasch <martin@zephir.ch>
 * @author Basil Suter <git@nadar.io>
 * @since 1.1.0
 */
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
        YII_DEBUG ? 'texttospeech.src.js' : 'texttospeech.js',
    ];

    /**
     * @var array An array with assets this asset depends on.
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
