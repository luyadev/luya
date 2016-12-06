<?php

namespace luya\styleguide;

use luya\base\CoreModuleInterface;

class Module extends \luya\base\Module implements CoreModuleInterface
{
    public $useAppLayoutPath = false;

    public $password = false;
    
    /**
     * @var array An array with asset bundles files:
     * 
     * ```php
     * 'assetFiles' => [
     *     'app\assets\ResourcesAsset',
     *     'app\assets\AnotherAssetFile',
     * ]
     * ```
     */
    public $assetFiles = [];
}
