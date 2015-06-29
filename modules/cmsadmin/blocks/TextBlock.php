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
        return 'mdi-editor-format-align-left';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Text', 'type' => 'zaa-textarea'],
                ['var' => 'textType', 'label' => 'Texttyp', 'initvalue' => 0, 'type' => 'zaa-select', 'options' =>
                    [
                        ['value' => '0', 'label' => 'Normaler Text'],
                        ['value' => '1', 'label' => 'Markdown Text'],
                    ],
                ],
            ],
        ];
    }

    public function getText()
    {
        $text = $this->getVarValue('content');

        if($this->getVarValue('textType')) {
            $text = $this->getParser()->parse($text);
        }

        return $text;
    }

    public function extraVars()
    {
        return [
            'text' => $this->getText(),
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty and vars.textType == 1 %}<p>{{ extras.text }}</p>{% elseif vars.content is not empty and vars.textType == 0 %}<p>{{ extras.text|nl2br }}</p>{% endif %}';
    }

    public function twigAdmin()
    {
        return '<p class="block__tag block__tag--p">{% if vars.content is empty %}<span class="block__empty-text">Es wurde noch kein Text eingegeben.</span>'.
        '{% elseif vars.content is not empty and vars.textType == 1 %}{{ extras.text }}{% elseif vars.content is not empty %}{{ extras.text|nl2br }}{% endif %}</p>';
    }
}
