<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\PhpBlock;

/**
 * WYSIWYG Block with ng-wig.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class WysiwygBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';
    
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
    public function blockGroup()
    {
        return TextGroup::className();
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
                ['var' => 'content', 'label' => Module::t('block_wysiwyg_content_label'), 'type' => self::TYPE_WYSIWYG],
            ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function admin()
    {
        return '{% if vars.content is empty %}<span class="block__empty-text">' . Module::t('block_wysiwyg_no_content') . '</span>{% else %}{{ vars.content }}{% endif %}';
    }
}
