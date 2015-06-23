<?php

namespace cmsadmin\blocks;

class ListBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return 'Auflistung';
    }

    public function icon()
    {
        return 'mdi-editor-format-list-bulleted';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'elements', 'label' => 'Elemente', 'type' => 'zaa-list-array'],
                ['var' => 'listType', 'label' => 'Type', 'type' => 'zaa-select', 'options' => [
                        ['value' => 'ul', 'label' => 'Stichpunktliste'],
                        ['value' => 'ol', 'label' => 'Nummerierte Liste'],
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
        return '{% if vars.elements is not empty %}<{{ extras.listType }}>{% for row in vars.elements %}<li>{{ row.value }}</li>{% endfor %}</{{ extras.listType }}>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.elements is empty%}<span class="block__empty-text">Es wurde noch keine Aufzählung eingegeben.</span>{% else %}<{{ extras.listType }} class="block__tag block__tag--{{ extras.listType }}">{% for row in vars.elements %}<li>{{ row.value }}</li>{% endfor %} </{{ extras.listType }}>{% endif %}';
    }
}
