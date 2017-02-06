<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\PhpBlock;

/**
 * Blockquote Block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class QuoteBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';

    /**
     * @inheritdoc
     */
    public $cacheEnabled = true;
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_quote_name');
    }
    
    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return TextGroup::className();
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'format_quote';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => Module::t('block_quote_content_label'), 'type' => self::TYPE_TEXT],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '{% if vars.content is not empty %}<blockquote>{{ vars.content }}</blockquote>{% else %}<span class="block__empty-text">' . Module::t('block_quote_no_content') . '</span>{% endif %}';
    }
}
