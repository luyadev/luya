<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\base\TwigBlock;

/**
 * Margin Top/Bottom block with Paragraph.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class SpacingBlock extends TwigBlock
{
    public $module = 'cms';
    
    public $cacheEnabled = true;

    public $spacingProperties = [
        ['value' => 1, 'label' => 'Kleiner Abstand'],
        ['value' => 2, 'label' => 'Mittlerer Abstand'],
        ['value' => 3, 'label' => 'Grosser Abstand'],
    ];

    public $defaultValue = 1;

    public function name()
    {
        return Module::t('block_spacing_name');
    }

    public function icon()
    {
        return 'format_line_spacing';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'spacing', 'label' => Module::t('block_spacing_spacing_label'), 'initvalue' => 1, 'type' => 'zaa-select', 'options' => $this->spacingProperties],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'spacing' => $this->getVarValue('spacing', $this->defaultValue),
            'spacingLabel' => $this->spacingProperties[$this->getVarValue('spacing', $this->defaultValue) - 1]['label'],
        ];
    }

    public function twigFrontend()
    {
        return '<p class="spacing-block spacing-block--{{extras.spacing}}">{% for i in 1..extras.spacing %}</br>{% endfor %}</p>';
    }

    public function twigAdmin()
    {
        return '<span class="block__empty-text">{{ extras.spacingLabel }}</span>';
    }
}
