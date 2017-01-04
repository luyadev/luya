<?php

namespace luya\cms\frontend\blocks;

use luya\TagParser;
use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\PhpBlock;

/**
 * Paragraph Text Block.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class TextBlock extends PhpBlock
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
        return TextGroup::className();
    }
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_text_name');
    }

    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'format_align_left';
    }

    /**
     * @inheritdoc
     */
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => Module::t('block_text_content_label'), 'type' => 'zaa-textarea'],
                ['var' => 'textType', 'label' => Module::t('block_text_texttype_label'), 'initvalue' => 0, 'type' => 'zaa-select', 'options' => [
                        ['value' => 0, 'label' => Module::t('block_text_texttype_normal')],
                        ['value' => 1, 'label' => Module::t('block_text_texttype_markdown')],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'cssClass', 'label' => Module::t('block_cfg_additonal_css_class'), 'type' => 'zaa-text'],
            ]
        ];
    }

    /**
     * Get the text based on type input.
     */
    public function getText()
    {
        $text = $this->getVarValue('content');

        if ($this->getVarValue('textType', 0) == 1) {
            return TagParser::convertWithMarkdown($text);
        }

        return nl2br($text);
    }

    /**
     * @inheritdoc
     */
    public function extraVars()
    {
        return [
            'text' => $this->getText(),
        ];
    }
    
    public function admin()
    {
        return '<p>{% if vars.content is empty %}<span class="block__empty-text">' . Module::t('block_text_no_content') . '</span>'.
                '{% elseif vars.content is not empty and vars.textType == 1 %}{{ extras.text }}{% elseif vars.content is not empty %}{{ extras.text }}{% endif %}</p>';
    }
}
