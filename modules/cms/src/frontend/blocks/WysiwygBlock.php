<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\TwigBlock;

/**
 * WYSIWYG Block with ng-wig.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class WysiwygBlock extends TwigBlock
{
    /**
     * @inheritDoc
     */
    public $cacheEnabled = true;
    
    /**
     * @inheritDoc
     */
    public function name()
    {
        return Module::t('block_wysiwyg_name');
    }

    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'format_color_text';
    }

    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => Module::t('block_wysiwyg_content_label'), 'type' => 'zaa-wysiwyg'],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function twigFrontend()
    {
        return '{% if vars.content is not empty %}{{ vars.content }}{% endif %}';
    }

    /**
     * @inheritDoc
     */
    public function twigAdmin()
    {
        return '{% if vars.content is empty %}<span class="block__empty-text">' . Module::t('block_wysiwyg_no_content') . '</span>{% else %}{{ vars.content }}{% endif %}';
    }
    
    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return TextGroup::className();
    }
}
