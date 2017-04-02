<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\PhpBlock;

/**
 * Heading-Title Block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class TitleBlock extends PhpBlock
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
        return Module::t('block_title_name');
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
        return 'format_size';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => Module::t('block_title_content_label'), 'type' => self::TYPE_TEXT],
                ['var' => 'headingType', 'label' => Module::t('block_title_headingtype_label'), 'type' => self::TYPE_SELECT, 'initvalue' => 'h1', 'options' => [
                        ['value' => 'h1', 'label' => Module::t('block_title_headingtype_heading') . ' 1'],
                        ['value' => 'h2', 'label' => Module::t('block_title_headingtype_heading') . ' 2'],
                        ['value' => 'h3', 'label' => Module::t('block_title_headingtype_heading') . ' 3'],
                        ['value' => 'h4', 'label' => Module::t('block_title_headingtype_heading') . ' 4'],
                        ['value' => 'h5', 'label' => Module::t('block_title_headingtype_heading') . ' 5'],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'cssClass', 'label' => Module::t('block_cfg_additonal_css_class'), 'type' => self::TYPE_TEXT],
            ]
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '{% if vars.content is not empty %}<{{vars.headingType}}>{{ vars.content }}</{{vars.headingType}}>{% else %}<span class="block__empty-text">' . Module::t('block_title_no_content') . '</span>{% endif %}';
    }
}
