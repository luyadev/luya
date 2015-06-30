<?php

namespace cmsadmin\blocks;

use Yii;

class ImageTextBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

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
                ['var' => 'imageId', 'label' => 'Bild Upload', 'type' => 'zaa-image-upload'],
                ['var' => 'text', 'label' => 'Text', 'type' => 'zaa-textarea'],
                ['var' => 'textPosition', 'label' => 'Textposition', 'type' => 'zaa-select', 'initvalue' => 'left', 'options' => [
                        ['value' => 'left', 'label' => 'Links'],
                        ['value' => 'right', 'label' => 'Rechts'],
                    ],
                ],
            ],
            'cfgs' => [
                    ['var' => 'floating', 'label' => 'Text umfliessend', 'type' => 'zaa-select', 'initvalue' => 1, 'options' => [
                            ['value' => '1', 'label' => 'Ja'],
                            ['value' => '0', 'label' => 'Nein'],
                        ],
                    ],
                ],
        ];
    }

    public function extraVars()
    {
        $img = Yii::$app->storage->image->get($this->getVarValue('imageId'), 0);

        return [
            'image' => $img,
            'textPosition' => $this->getVarValue('textPosition', 'left'),
            'imageWidth' => getimagesize($img->source)[0]
        ];
    }

    public function twigFrontend()
    {
        return  '{% if extras.image and vars.text %}'.
                    '<div>'.
                        '<img class="{% if extras.textPosition == "left" %}pull-right{% else %}pull-left{% endif %} img-responsive" src="{{ extras.image.source }}" style="{% if not cfgs.floating %}display:inline-block;width:40%;max-width:{{ extras.imageWidth }}px{% endif %}">'.
                        '<p class="{% if not cfgs.floating %}{% if extras.textPosition == "left"%}pull-left{% else %}pull-right{% endif %}{% endif %}" style="{% if not cfgs.floating %}display:inline-block;width:58%{% endif %}">{{ vars.text }}</p>'.
                    '</div>'.
                    '<br style="clear:both" />'.
                '{% endif %}';
    }

    public function twigAdmin()
    {

        return  '{% if not extras.image.source %}'.
                    '<span class="block__empty-text">Es wurde noch kein Bild Hochgeladen.</span>'.
                '{% endif %}'.
                '{% if not vars.text %}'.
                    '<span class="block__empty-text">Es wurde noch kein Text angegeben.</span>'.
                '{% endif %}'.
                '{% if extras.image.source and vars.text %}'.
                    '<img src="{{ extras.image.source }}" border=0 style="max-height:100px;{% if cfgs.floating == 0 %}display:inline-block;width:40%;{% endif %}max-width:{{ extras.imageWidth }}px;float:{% if extras.textPosition == "left" %}right{% else %}left{% endif %}">'.
                    '<p style="{% if cfgs.floating == 0 %};display:inline-block;width:58%;float:{% if extras.textPosition == "left" %}left{% else %}right;{% endif %}{% else %}float:none;{% endif %}">{{ vars.text }}</p>'.
                '{% endif %}';

    }
}
