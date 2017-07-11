<?php

namespace app\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;

/**
 * Color Wheel Test Block.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0-dev. 
 */
class ColorWheelTestBlock extends PhpBlock
{
    /**
     * @var bool Choose whether a block can be cached trough the caching component. Be carefull with caching container blocks.
     */
    public $cacheEnabled = true;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true
     */
    public $cacheExpiration = 3600;

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return ProjectGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Color Wheel Test';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'color_lens'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'color', 'label' => 'Color', 'type' => self::TYPE_COLOR],
            ],
        ];
    }
    
    /**
     * {@inheritDoc} 
     *
     * @param {{vars.color}}
    */
    public function admin()
    {
        return '<p>
                    <span style="display: inline-block; width: 100%; height: 50px; background-color: {{vars.color}};"></span>
                </p>';
    }
}