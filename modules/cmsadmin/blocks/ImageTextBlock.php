<?php

namespace cmsadmin\blocks;

use Yii;
use cebe\markdown\GithubMarkdown;

class ImageTextBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public $_parser = null;

    public $cacheEnabled = true;
    
    private $defaultMargin = '20px';

    private $_source = null;

    public function getParser()
    {
        if ($this->_parser === null) {
            $this->_parser = new GithubMarkdown();
        }

        return $this->_parser;
    }

    public function name()
    {
        return 'Text mit Bild';
    }

    public function icon()
    {
        return 'recent_actors';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'text', 'label' => 'Text', 'type' => 'zaa-textarea'],
                ['var' => 'imageId', 'label' => 'Bild Upload', 'type' => 'zaa-image-upload'],
                ['var' => 'imagePosition', 'label' => 'Bildposition', 'type' => 'zaa-select', 'initvalue' => 'left', 'options' => [
                        ['value' => 'left', 'label' => 'Links'],
                        ['value' => 'right', 'label' => 'Rechts'],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'margin', 'label' => 'Abstand des Bildes zum Text', 'type' => 'zaa-select', 'initvalue' => $this->defaultMargin, 'options' => [
                            ['value' => '5px', 'label' => '0 Pixel'],
                            ['value' => '10px', 'label' => '10 Pixel'],
                            ['value' => '15px', 'label' => '20 Pixel'],
                            ['value' => '15px', 'label' => '30 Pixel'],
                            ['value' => '15px', 'label' => '40 Pixel'],
                            ['value' => '15px', 'label' => '50 Pixel'],
                    ],
                ],
                ['var' => 'textType', 'label' => 'Texttyp', 'initvalue' => 1, 'type' => 'zaa-select', 'options' => [
                        ['value' => '0', 'label' => 'Normaler Text'],
                        ['value' => '1', 'label' => 'Markdown Text'],
                    ],
                ],
            ],
        ];
    }

    public function getText()
    {
        $text = $this->getVarValue('text');

        if ($this->getCfgValue('textType')) {
            $text = $this->getParser()->parse($text);
        }

        return $text;
    }

    public function getImageSource()
    {
        if ($this->_source === null) {
            $img = Yii::$app->storage->getImage($this->getVarValue('imageId'), 0);

            $this->_source = $img ? $img->source : false;
        }

        return $this->_source;
    }

    public function extraVars()
    {
        return [
            'imageSource' => $this->getImageSource(),
            'imagePosition' => $this->getVarValue('imagePosition', 'left'),
            'imageWidth' => $this->getImageSource() ? @getimagesize($this->getImageSource())[0] : 0,
            'margin' => $this->getCfgValue('margin', $this->defaultMargin),
            'text' => $this->getText(),
        ];
    }

    public function twigFrontend()
    {
        return  '{% if extras.imageSource and vars.text %}'.
                    '<div>'.
                        '<img class="{% if extras.imagePosition == "left" %}pull-left{% else %}pull-right{% endif %} img-responsive" src="{{ extras.imageSource }}" style="{% if extras.imagePosition == "right" %}margin-left:{{ extras.margin }}{% else %}margin-right:{{ extras.margin }}{% endif %};margin-bottom:{{ extras.margin }}; max-width: 50%;">'.
                        '<div>{% if cfgs.textType == 1 %}{{ extras.text }}{% else %}<p>{{ extras.text|nl2br }}</p>{% endif %}</div>'.
                    '</div>'.
                    '<br style="clear:both" />'.
                '{% endif %}';
    }

    public function twigAdmin()
    {
        return  '{% if not extras.imageSource %}'.
                    '<span class="block__empty-text">Es wurde noch kein Bild Hochgeladen. </span>'.
                '{% endif %}'.
                '{% if not vars.text %}'.
                    '<span class="block__empty-text">Es wurde noch kein Text angegeben.</span>'.
                '{% endif %}'.
                '{% if extras.imageSource and vars.text %}'.
                    '<img src="{{ extras.imageSource }}" border=0 style="{% if extras.imagePosition == "left" %}float:left;{% else %}float:right{% endif %};{% if extras.imagePosition == "right" %}margin-left:{{ extras.margin }}{% else %}margin-right:{{ extras.margin }}{% endif %};margin-bottom:{{ extras.margin }}; max-width: 50%;"">'.
                    '<p>{% if cfgs.textType == 1 %}{{ extras.text }}{% else %}{{ extras.text|nl2br }}{% endif %}</p>'.
                '{% endif %}';
    }
}
