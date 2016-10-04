<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\TwigBlock;

/**
 * UL/OL list block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class ListBlock extends TwigBlock
{
    public $module = 'cms';

    public $cacheEnabled = true;
    
    public function name()
    {
        return Module::t('block_list_name');
    }

    public function icon()
    {
        return 'view_list';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'elements', 'label' => Module::t('block_list_elements_label'), 'type' => 'zaa-list-array'],
                ['var' => 'listType', 'label' => Module::t('block_list_listtype_label'), 'initvalue' => 'ul', 'type' => 'zaa-select', 'options' => [
                        ['value' => 'ul', 'label' => Module::t('block_list_listtype_ul')],
                        ['value' => 'ol', 'label' => Module::t('block_list_listtype_ol')],
                    ],
                ],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'listType' => $this->getVarValue('listType', 'ul'),
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.elements is not empty %}<{{ extras.listType }}>{% for row in vars.elements if row.value is not empty %}<li>{{ row.value }}</li>{% endfor %}</{{ extras.listType }}>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.elements is empty%}<span class="block__empty-text">' . Module::t('block_list_no_content') . '</span>{% else %}<{{ extras.listType }}>{% for row in vars.elements if row.value is not empty %}<li>{{ row.value }}</li>{% endfor %}</{{ extras.listType }}>{% endif %}';
    }
    
    public function getBlockGroup()
    {
        return TextGroup::className();
    }
}
