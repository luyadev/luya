<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\LayoutGroup;
use luya\cms\base\TwigBlock;

/**
 * Layout/Grid Block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class LayoutBlock extends TwigBlock
{
    public $module = 'cms';

    public $isContainer = true;

    public function name()
    {
        return Module::t('block_layout_name');
    }

    public function icon()
    {
        return 'view_column';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'width', 'label' => Module::t('block_layout_width_label'), 'initvalue' => 6, 'type' => 'zaa-select', 'options' => [
                        ['value' => 1, 'label' => '1'],
                        ['value' => 2, 'label' => '2'],
                        ['value' => 3, 'label' => '3'],
                        ['value' => 4, 'label' => '4'],
                        ['value' => 5, 'label' => '5'],
                        ['value' => 6, 'label' => '6'],
                        ['value' => 7, 'label' => '7'],
                        ['value' => 8, 'label' => '8'],
                        ['value' => 9, 'label' => '9'],
                        ['value' => 10, 'label' => '10'],
                        ['value' => 11, 'label' => '11'],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'leftColumnClasses', 'label' => Module::t('block_layout_left_column_css_class'), 'type' => 'zaa-text'],
                ['var' => 'rightColumnClasses', 'label' => Module::t('block_layout_right_column_css_class'), 'type' => 'zaa-text'],
                ['var' => 'rowDivClass', 'label' => Module::t('block_layout_row_column_css_class'), 'type' => 'zaa-text'],
            ],
            'placeholders' => [
                ['var' => 'left', 'label' => Module::t('block_layout_placeholders_left')],
                ['var' => 'right', 'label' => Module::t('block_layout_placeholders_right')],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'leftWidth' => $this->getVarValue('width', 6),
            'rightWidth' => 12 - $this->getVarValue('width', 6),
        ];
    }

    public function twigFrontend()
    {
        return '<div class="row {{cfgs.rowDivClass}}"><div class="col-md-{{ extras.leftWidth }} {{ cfgs.leftColumnClasses }}">{{ placeholders.left }}</div><div class="col-md-{{ extras.rightWidth }} {{ cfgs.rightColumnClasses }}">{{ placeholders.right }}</div></div>';
    }

    public function twigAdmin()
    {
        return '';
    }
    
    public function getBlockGroup()
    {
        return LayoutGroup::className();
    }
}
