<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\TagParser;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\TwigBlock;

/**
 * Paragraph Text Block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class TextBlock extends TwigBlock
{
    public $module = 'cms';
    
    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_text_name');
    }

    public function icon()
    {
        return 'format_align_left';
    }

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

    public function getText()
    {
        $text = $this->getVarValue('content');

        if ($this->getVarValue('textType') == 1) {
            return TagParser::convertWithMarkdown($text);
        }

        return $text;
    }

    public function extraVars()
    {
        return [
            'text' => $this->getText(),
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty and vars.textType == 1 %}{{ extras.text }}{% elseif vars.content is not empty and vars.textType == 0 %}<p{% if cfgs.cssClass is not empty %} class="{{cfgs.cssClass}}"{% endif %}>{{ extras.text|nl2br }}</p>{% endif %}';
    }

    public function twigAdmin()
    {
        return '<p>{% if vars.content is empty %}<span class="block__empty-text">' . Module::t('block_text_no_content') . '</span>'.
        '{% elseif vars.content is not empty and vars.textType == 1 %}{{ extras.text }}{% elseif vars.content is not empty %}{{ extras.text|nl2br }}{% endif %}</p>';
    }

    public function getBlockGroup()
    {
        return TextGroup::className();
    }
}
