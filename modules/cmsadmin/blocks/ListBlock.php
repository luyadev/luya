<?php

namespace cmsadmin\blocks;

class ListBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return 'Auflistung';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'elements', 'label' => 'Elemente', 'type' => 'zaa-list-array'],
            ],
            'cfgs' => [
                ['var' => 'listType', 'label' => 'Type', 'type' => 'zaa-input-select', 'options' => [
                        ['value' => 'ul', 'label' => 'UL-Liste'],
                        ['value' => 'ol', 'label' => 'OL-Liste'],
                    ],
                ],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '<{{cfgs.listType}}>{% for row in vars.elements %}<li>{{ row.value }}</li>{% endfor %}</{{cfgs.listType}}>';
    }

    public function twigAdmin()
    {
        return '<{{ cfgs.listType }}>{% for row in vars.elements %}<li>{{ row.value }}</li>{% endfor %} </{{ cfgs.listType }}>';
    }
}
