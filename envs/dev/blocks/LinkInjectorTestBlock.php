<?php

namespace app\blocks;

use Yii;
use luya\cms\injectors\LinkInjector;

/**
 * Block created with Luya Block Creator Version 1.0.0-RC1-dev at 21.09.2016 15:28
 */
class LinkInjectorTestBlock extends \luya\cms\base\PhpBlock
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

    public function injectors()
    {
        return [
            'link' => new LinkInjector(),
        ];
    }
    
    public function name()
    {
        return 'LinkInjectorTestBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: https://design.google.com/icons/
    }

    public function config()
    {
        return [];
    }

    /**
     * Available twig variables:
     */
    public function admin()
    {
        return '<p>{{ dump(extras.link) }}</p>';
    }
}
