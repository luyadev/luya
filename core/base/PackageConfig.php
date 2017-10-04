<?php

namespace luya\base;

use yii\base\Object;

/**
 * Represents a package config item from the PackageInstaller.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PackageConfig extends Object
{
    public $bootstrap = [];
    
    public $blocks = [];
    
    public $package;
}
