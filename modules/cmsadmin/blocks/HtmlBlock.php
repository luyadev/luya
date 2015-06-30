<?php

namespace cmsadmin\blocks;

class HtmlBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Html';
    }

    /**
     * @todo check correct materialized icon (code)
     */
    public function icon()
    {
        return 'mdi-action-settings-ethernet';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'html', 'label' => 'HTML-Inhalt', 'type' => 'zaa-textarea'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '{{ vars.html | raw }}';
    }

    public function twigAdmin()
    {
        return '{% if vars.html is empty %}<span class="block__empty-text">Es wurde noch kein HTML Code eingegeben.</span>{% else %}{{ vars.html | raw }}{% endif %}';
    }
}
