<?php
namespace cmsadmin\blocks;

class ListBlock extends \cmsadmin\base\Block
{
    public $name = 'Auflistungen';

    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'elements', 'label' => 'Elemente', 'type' => 'zaa-list-array'],
            ],
            'cfgs' => [
                ['var' => 'listType', 'label' => 'Type', 'type' => 'zaa-input-select', 'options' => [
                    ['value' => 'ul', 'label' => 'UL-Liste'],
                    ['value' => 'ol', 'label' => 'OL-Liste']
                ]]
            ],
        ];
    }

    public function getTwigFrontend()
    {
        return '<{{cfgs.listType}}>{% for row in vars.elements %}<li>{{ row.value }}</li>{% endfor %}</{{cfgs.listType}}>';
    }

    public function getTwigAdmin()
    {
        return '<{{ cfgs.listType }}>{% for row in vars.elements %}<li>{{ row.value }}</li>{% endfor %} </{{ cfgs.listType }}>';
    }
}
