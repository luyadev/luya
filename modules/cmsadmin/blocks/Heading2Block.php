<?php
namespace cmsadmin\blocks;

class Heading2Block extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift 2', 'type' => 'zaa-input-text'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '<h2>{{ vars.heading }}</h2>';
    }

    public function twigAdmin()
    {
        return '<h2>{{ vars.heading }}</h2>';
    }

    public function name()
    {
        return 'Überschrift 2';
    }
}
