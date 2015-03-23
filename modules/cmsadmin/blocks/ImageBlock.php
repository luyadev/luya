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

    public function getTwigFrontend()
    {
        return '<p>{{vars.imageId}}</p>';
    }

    public function getTwigAdmin()
    {
        return '<p>{{vars.imageId}}</p>';
    }

    public function getName()
    {
        return 'Bild';
    }
}
