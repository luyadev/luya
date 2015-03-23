<?php
namespace cmsadmin\blocks;

class Heading1Block extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';

    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift 1', 'type' => 'zaa-input-text'],
            ],
        ];
    }

    public function getTwigFrontend()
    {
        return '<h1>{{ vars.heading }}</h1>';
    }

    public function getTwigAdmin()
    {
        return '<h1>{{ vars.heading }}</h1>';
    }

    public function getName()
    {
        return 'Überschrift 1';
    }
}
