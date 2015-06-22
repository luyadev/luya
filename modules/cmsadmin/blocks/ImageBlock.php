<?php

namespace cmsadmin\blocks;

use Yii;

class ImageBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';
    
    public function name()
    {
        return 'Bild';
    }

    public function icon()
    {
        return "mdi-image-crop-original";
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'imageId', 'label' => 'Bild Upload', 'type' => 'zaa-image-upload'],
                ['var' => 'caption', 'label' => 'Bildunterschrift', 'type' => 'zaa-text'],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'image' => Yii::$app->storage->image->get($this->getVarValue('imageId'), 0),
        ];
    }

    public function twigFrontend()
    {
        $image = '{% if extras.image is not empty %}<div class="image"><figure><img class="img-responsive" src="{{extras.image.source}}" {% if vars.caption is not empty %}alt="{{vars.caption}}" title="{{vars.caption}}"{% endif %} border="0" />';
        $image.= '{% if vars.caption is not empty %}<figcaption>{{vars.caption}}</figcaption>{% endif %}</figure></div>{% endif %}';
        return $image;
    }

    public function twigAdmin()
    {
        $image = '<p>{% if extras.image.source %}<img src="{{extras.image.source}}" border="0" height="100" />{% else %}<strong>Es wurde noch kein Bild Hochgeladen.</strong>{% endif %}</p>';
        $image.= '{% if vars.caption is not empty %}{{vars.caption}}{% endif %}';

        return $image;
    }
}
