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
    
    public function getFieldHelp()
    {
        return [
                'entries' => 'alsdfjalsdkfjasd',
        ];
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
                ['var' => 'entries', 'label' => 'Einträge', 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' => [
                    ['var' => 'color', 'label' => 'Color', 'type' => self::TYPE_LINK],
                        
                ]],
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
        return '<div style="margin: -15px 0 0 -15px; display: block; width: 100%;">
                    {% for entry in vars.entries %}
                        <div style="display: inline-block; width: 50px; height: 50px; background-color: {{entry.color}}; margin: 15px 0 0 15px;"></div>
                    {% endfor %}
                </div>';
    }
}
