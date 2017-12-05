<?php

namespace luya\base;

use yii\base\BaseObject;

/**
 * Represents a package config item from the PackageInstaller.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PackageConfig extends BaseObject
{
    public $bootstrap = [];
    
    public $blocks = [];
    
    public $package;
}
