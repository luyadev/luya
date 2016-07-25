<?php

namespace app\blocks;

use Yii;

/**
 * Block created with Luya Block Creator Version 1.0.0-beta8-dev at 25.07.2016 12:42
 */
class PhpblocktestBlock extends \cmsadmin\base\PhpBlock
{
    /**
     * @var bool Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = false;

    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = false;

    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    public function name()
    {
        return 'PhpblocktestBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
        ];
    }

    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
        ];
    }

    /**
     * Available twig variables:
     */
    public function admin()
    {
        return '<p>My Admin Twig of this Block</p>';
    }
}
