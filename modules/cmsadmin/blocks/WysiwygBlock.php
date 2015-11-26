<?php

namespace cmsadmin\blocks;

class WysiwygBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;
    
    public function name()
    {
        return 'Texteditor';
    }

    public function icon()
    {
        return 'format_color_text';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Inhalt', 'type' => 'zaa-wysiwyg'],
            ],
        ];
    }

    public function getFieldHelp()
    {
        return [
            'content' => 'Klicken Sie in die erste Zeile um mit der Eingabe zu beginnen.',
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty %}{{ vars.content }}{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.content is empty %}<span class="block__empty-text">Es wurde noch kein Text eingegeben.</span>{% else %}{{ vars.content }}{% endif %}';
    }
}
