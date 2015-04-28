<?php
namespace cmsadmin\blocks;

class ImageBlock extends \cmsadmin\base\Block
{
    public function config()
    {
        return [
            'vars' => [
                ['var' => 'imageId', 'label' => 'Bild', 'type' => 'zaa-image-upload'],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'image' => \yii::$app->luya->storage->image->get($this->getVarValue('imageId'))
        ];
    }
    
    public function twigFrontend()
    {
        return '<img src="{{extras.image.source}}" border="0" /> {{dump(extras)}}';
    }

    public function twigAdmin()
    {
        return '<p>{% if extras.image.source %}<img src="{{extras.image.source}}" border="0" height="100" />{% else %}<strong>Es wurde noch kein Bild Hochgeladen.</strong>{% endif %}</p>';
    }

    public function name()
    {
        return 'Bild';
    }
}
