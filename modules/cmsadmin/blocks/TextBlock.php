<?php

namespace cmsadmin\blocks;

use \cebe\markdown\GithubMarkdown;

class TextBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public $_parser = null;

    public function getParser()
    {
        if( $this->_parser === null) {
            $this->_parser = new GithubMarkdown();
        }

        return $this->_parser;
    }

    public function name()
    {
        return 'Text';
    }

    public function icon()
    {
        return "mdi-editor-format-align-left";
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Text', 'type' => 'zaa-textarea'],
                ['var' => 'textType', 'label' => 'Texttyp', 'type' => 'zaa-select', 'options' =>
                    [
                        ['value' => '0', 'label' => 'Normaler Text'],
                        ['value' => '1', 'label' => 'Markdown Text'],
                    ],
                ],
            ],
        ];
    }

    public function extraVars()
    {
        $text = $this->getVarValue("content");

        if($this->getVarValue("textType")) {
            $text = $this->getParser()->parse($text);
        }

        return [
            "text" => $text,
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty %}<p>{{ extras.text }}</p>{% endif %}';
    }

    public function twigAdmin()
    {
        return '<p>{% if vars.content is empty %}<strong>Es wurde noch kein Text eingegeben.</strong>{% else %}{{ extras.text }}{% endif %}</p>';
    }
}
