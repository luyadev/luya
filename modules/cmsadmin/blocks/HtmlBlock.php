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
     * @todo check correct materialized icon
     */
    public function icon()
    {
        return "code";
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
        return '<pre>{{ vars.html | escape }}</pre>';
    }
}
