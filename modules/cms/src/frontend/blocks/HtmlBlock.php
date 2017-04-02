<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\cms\base\PhpBlock;

/**
 * HTML Block
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class HtmlBlock extends PhpBlock
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
    public function blockGroup()
    {
        return DevelopmentGroup::className();
    }
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_html_name');
    }
    
    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'code';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'html', 'label' => Module::t('block_html_html_label'), 'type' => 'zaa-textarea'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '{% if vars.html is empty %}<span class="block__empty-text">' . Module::t('block_html_no_content') . '</span>{% else %}<p><code>{{ vars.html | escape }}</code></p>{% endif %}';
    }
}
