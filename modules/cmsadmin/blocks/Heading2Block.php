<?php
namespace cmsadmin\blocks;

class Heading2Block extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';

    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift 2', 'type' => 'zaa-input-text'],
            ],
        ];
    }

    public function getTwigFrontend()
    {
        return '<h2>{{ vars.heading }}</h2>';
    }

    public function getTwigAdmin()
    {
        return '<h2>{{ vars.heading }}</h2>';
    }

    public function getName()
    {
        return 'Überschrift 2';
    }
}
