<?php

namespace cmsadmin\blocks;

use Yii;

class ImageTextBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    private $defaultMargin = '20px';

    private $_source = null;


    public function name()
    {
        return 'Text mit Bild';
    }

    public function icon()
    {
        return 'mdi-av-recent-actors';
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
            ],
        ];
    }

    public function getImageSource()
    {
        if ($this->_source === null) {

            $img = Yii::$app->storage->image->get($this->getVarValue('imageId'), 0);

            $this->_source = $img ? $img->source : false;

        }

        return $this->_source;
    }

    public function extraVars()
    {
        return [
            'imageSource' => $this->getImageSource(),
            'imagePosition' => $this->getVarValue('imagePosition', 'left'),
            'imageWidth' => $this->getImageSource() ? getimagesize($this->getImageSource())[0] : 0,
            'margin' => $this->getCfgValue('margin',$this->defaultMargin),
        ];
    }

    public function twigFrontend()
    {
        return  '{% if extras.imageSource and vars.text %}'.
                    '<div>'.
                        '<img class="{% if extras.imagePosition == "left" %}pull-left{% else %}pull-right{% endif %} img-responsive" src="{{ extras.imageSource }}" style="{% if extras.imagePosition == "right" %}margin-left:{{ extras.margin }}{% else %}margin-right:{{ extras.margin }}{% endif %};margin-bottom:{{ extras.margin }}; max-width: 50%;">'.
                        '<p>{{ vars.text }}</p>'.
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
                    '<img src="{{ extras.imageSource }}" border=0 style="{% if extras.imagePosition == "left" %}float:left;{% else %}float:right{% endif %};{% if extras.imagePosition == "right" %}margin-left:{{ extras.margin }}{% else %}margin-right:{{ extras.margin }}{% endif %};margin-bottom:{{ extras.margin }}"">'.
                    '<p>{{ vars.text }}</p>'.
                '{% endif %}';
    }
}
