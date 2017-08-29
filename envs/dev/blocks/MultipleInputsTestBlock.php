<?php

namespace app\blocks;

use luya\cms\base\PhpBlock;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\cms\helpers\BlockHelper;

/**
 * Color Wheel Test Block.
 *
 * File has been created with `block/create` command on LUYA version 1.0.0-dev.
 */
class MultipleInputsTestBlock extends PhpBlock
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
        return DevelopmentGroup::class;
    }

    /**
     * @inheritDoc
     */
    public function name()
    {
        return 'Multiple Inputs Test';
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'grid_on'; // see the list of icons on: https://design.google.com/icons/
    }
 
    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'entries', 'label' => 'Entries', 'type' => self::TYPE_MULTIPLE_INPUTS, 'options' => [
                    ['var' => 'title', 'label' => 'Title', 'type' => self::TYPE_TEXT],
                    ['var' => 'description', 'label' => 'Description', 'type' => self::TYPE_TEXTAREA],
                    ['var' => 'image', 'label' => 'Images', 'type' => self::TYPE_IMAGEUPLOAD],
                ]],
            ],
        ];
    }

    public function extraVars()
    {
        $entries = [];

        foreach($this->getVarValue('entries', []) as $entry) {
            if( isset($entry['title']) && isset($entry['description']) && isset($entry['image']) ) {
                $entries[] = [
                    'title' => $entry['title'],
                    'description' => $entry['description'],
                    'image' => BlockHelper::imageUpload($entry['image'])
                ];
            }
        }

        return [
            'entries' => $entries
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
                    {% for entry in extras.entries %}
                        <div style="display: inline-block; padding: 15px; background-color: #f0f0f0; margin: 15px 0 0 15px;">
                            <p>
                                <strong>{{entry.title}}</strong><br />
                                {{entry.description}}
                            </p>
                            <img src="{{entry.image.source}}" style="width: 100%; max-width: 150px; height: auto;" />
                        </div>
                    {% endfor %}
                </div>';
    }
}
