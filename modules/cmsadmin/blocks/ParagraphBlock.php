<?php

namespace cmsadmin\blocks;

class ParagraphBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'Text Absatz';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Inhalt', 'type' => 'zaa-textarea'],
                ['var' => 'parseMarkdown', 'label' => 'Parse Markdown?', 'type' => 'zaa-select', 'options' => [
                        ['id' => 0 , 'label' => 'Nein'],
                        ['id' => 1, 'label' => 'Ja'],
                    ],
                ],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '<p>{{ vars.content|nl2br }}</p>';
    }

    public function twigAdmin()
    {
        return '<p>{{ vars.content }}</p>';
    }
}
