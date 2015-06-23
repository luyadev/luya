<?php

namespace cmsadmin\blocks;

class WysiwygBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'Texteditor';
    }

    public function icon()
    {
        return "mdi-editor-format-color-text";
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Inhalt', 'type' => 'zaa-wysiwyg']
            ]
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