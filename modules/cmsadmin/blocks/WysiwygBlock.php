<?php

namespace cmsadmin\blocks;

class WysiwygBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'WYSIWYG';
    }
    
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'wysiwyg', 'label' => 'Inhalt', 'type' => 'zaa-wysiwyg']
            ]
        ];
    }
    
    public function twigFrontend()
    {
        return '{{ vars.wysiwyg }}';
    }
    
    public function twigAdmin()
    {
        return '{{ vars.wysiwyg }}';
    }
}