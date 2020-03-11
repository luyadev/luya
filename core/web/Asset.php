<?php

namespace luya\web;

use luya\helpers\Inflector;
use ReflectionClass;

/**
 * Asset Bundles.
 *
 * The main differente to the Yii implementation is that {{$sourcePath}} has a default value which points into a `/resources` folder containing
 * the name of the assets itself.
 * 
 * Assuming an `MySuperAsset` asset in `/app` folder will lookup all files under `/app/resources/my-super-asset/...`.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Asset extends \yii\web\AssetBundle
{
    /**
     * @var string When $sourcePath is null, the Asset object will automaticcaly assign the current 
     */
    public $defaultSourcePathFolder = 'resources';

    public function init()
    {
        parent::init();

        if ($this->sourcePath === null) {
            $class = new ReflectionClass($this);
            $this->sourcePath = dirname($class->getFileName()) . DIRECTORY_SEPARATOR . $this->defaultSourcePathFolder . DIRECTORY_SEPARATOR . Inflector::camel2id($class->getShortName());
        }
    }
}
