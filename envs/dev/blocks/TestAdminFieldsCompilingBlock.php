<?php

namespace app\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\ProjectGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Test Admin Fields Compiling Block.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0-dev. 
 */
class TestAdminFieldsCompilingBlock extends PhpBlock
{
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
        return 'Test Admin Fields Compiling Block';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'extension'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                 ['var' => 'text', 'label' => 'text', 'type' => self::TYPE_TEXT],
                 ['var' => 'area', 'label' => 'area', 'type' => self::TYPE_TEXTAREA],
            ],
        ];
    }
    
    /**
     * {@inheritDoc} 
     *
     * @param {{vars.area}}
     * @param {{vars.text}}
    */
    public function admin()
    {
        return  '<p style="display: block; text-align: right; font-weight: bold; text-transform: uppercase;">Test Admin Fields Compiling Block Admin View</p>'.
                '<hr>' .
                '{% if vars.text is not empty %}' .
                '<p><b>text</b>: {{vars.text}}</p>' .
                '{% endif %}'.
                '{% if vars.area is not empty %}' .
                '<p><b>area</b>: {{vars.area}}</p>' .
                '{% endif %}'.
                '<hr>';
    }
}