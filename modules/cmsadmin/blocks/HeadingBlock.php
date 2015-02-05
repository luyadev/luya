<?php
namespace cmsadmin\blocks;

class HeadingBlock extends \cmsadmin\base\Block
{
    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift', 'type' => 'zaa-input-text']
            ]
        ];
    }
    
    public function getTwigFrontend()
    {
        return '<h1>{{ vars.heading }}</h1>';
    }
    
    public function getTwigAdmin()
    {
        return '<p>{{ vars.heading }}</p>';
    }
    
    public function getName()
    {
        return 'Read_Heading_Name';
    }
}