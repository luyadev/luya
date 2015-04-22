<?php
namespace cmsadmin\blocks;

class ImageBlock extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';

    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'imageId', 'label' => 'Bild', 'type' => 'zaa-image-upload'],
            ],
        ];
    }

    public function getExtraVars()
    {
        return [
            'image' => \yii::$app->luya->storage->image->get($this->getVarValue('imageId'))
        ];
    }
    
    public function getTwigFrontend()
    {
        return '<img src="{{extras.image.source}}" border="0" /> {{dump(extras)}}';
    }

    public function getTwigAdmin()
    {
        return '<p>{% if extras.image.source %}<img src="{{extras.image.source}}" border="0" height="100" />{% else %}<strong>Es wurde noch kein Bild Hochgeladen.</strong>{% endif %}</p>';
    }

    public function getName()
    {
        return 'Bild';
    }
}
