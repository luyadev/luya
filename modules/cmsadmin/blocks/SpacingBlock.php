<?php

namespace cmsadmin\blocks;

class SpacingBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public $spacingProperties = [
        ['value' => 1, 'label' => 'Kleiner Abstand'],
        ['value' => 2, 'label' => 'Mittlerer Abstand'],
        ['value' => 3, 'label' => 'Grosser Abstand'],
    ];

    public $defaultValue = 2;

    public function name()
    {
        return 'Abstand';
    }

    public function icon()
    {
        return 'format_line_spacing';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'spacing', 'label' => 'Abstand', 'initvalue' => 1, 'type' => 'zaa-select', 'options' => $this->spacingProperties],
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
        return '{% for i in 1..extras.spacing %}<p></br></p>{% endfor %}';
    }

    public function twigAdmin()
    {
        return '<span class="block__empty-text">{{ extras.spacingLabel }}</span>';
    }
}
