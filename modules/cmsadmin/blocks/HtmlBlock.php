<?php

namespace cmsadmin\blocks;

class HtmlBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'Html';
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
        return '<pre style="background-color:#666; padding:10px;">{{ vars.html | escape }}</pre>';
    }
}
