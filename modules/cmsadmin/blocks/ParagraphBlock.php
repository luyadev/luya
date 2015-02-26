<?php
namespace cmsadmin\blocks;

class ParagraphBlock extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';
    
    public $name = 'Paragraph Text';
    
    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Inhalt', 'type' => 'zaa-textarea'],
                ['var' => 'parseMarkdown', 'label' => 'Parse Markdown?', 'type' => 'zaa-input-select', 'options' => 
                    [
                        ["id" => 0 , "label" => "Nein" ] , ["id" => 1, "label" => "Ja"]   
                    ]
                ]
            ]
        ];
    }
    
    public function getTwigFrontend()
    {
        return '<p>{{ vars.content }}</p>';
    }
    
    public function getTwigAdmin()
    {
        return '<p>{{ vars.content }}</p>';
    }
}