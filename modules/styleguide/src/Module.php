<?php

namespace luya\styleguide;

use luya\base\CoreModuleInterface;

/**
 * Styleguide Module.
 *
 * This module is bound to the {{luya\web\Element}} component.
 *
 * In order to configure the Module in your config file you can use the example below:
 *
 * ```php
 * 'modules' => [
 *     // ...
 *     'styleguide' => [
 *         'class' => 'luya\styleguide\Module',
 *         'divOptions' => ['class' => 'container container--styleguide'],
 *         'password' => 'PasswordToProtectedTheStyleguideOnProd',
 *         'assetFiles' => [
 *             'app\assets\ResourcesAsset',
 *             'app\assets\AnotherAssetFile',
 *         ],
 *     ]
 *     // ...
 * ]
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class Module extends \luya\base\Module implements CoreModuleInterface
{
    /**
     * @inheritdoc
     */
    public $useAppLayoutPath = false;

    /**
     * @var string|boolean The password to protected the styleguide.
     */
    public $password = false;
    
    /**
     * @var array Options to pass to the div which encloses the rendered element.
     */
    public $divOptions = ['style' => 'padding:10px; border:5px solid #F0F0F0; margin-bottom:20px', 'class' => 'container container--styleguide'];
    
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
