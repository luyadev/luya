<?php

namespace luya\gallery\admin\blocks;

use luya\cms\base\Block;
use luya\cms\models\NavItem;
use luya\gallery\models\Album;

class GalleryAlbum extends Block
{
    public $module = 'gallery';

    private $_dropdown = [];

    private $_alben = [];

    public function init()
    {
        foreach (NavItem::fromModule('gallery') as $item) {
            $this->_dropdown[] = ['value' => $item->id, 'label' => $item->title];
        }

        foreach (Album::find()->asArray()->all() as $item) {
            $this->_alben[] = ['value' => $item['id'], 'label' => $item['title']];
        }
    }

    public function name()
    {
        return 'Gallery: Album';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'albumId', 'label' => 'Album', 'type' => 'zaa-select', 'options' => $this->_alben],
            ],
            'cfgs' => [
                ['var' => 'nav_item_id', 'label' => 'Link zum Gallery-Modul', 'type' => 'zaa-select', 'options' => $this->_dropdown],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'album' => Album::find()->where(['id' => $this->getVarValue('albumId')])->one(),
        ];
    }

    public function twigAdmin()
    {
        return '<p style="padding:20px 0px; font-size:20px;"><i class="fa fa-image fa-2x"></i> Gallery-Album: <strong>{{ extras.album.title }}</strong></p>';
    }

    public function twigFrontend()
    {
        return '<h1>{{ extras.album.title }}</h1><p>{{ extras.album.description }}</p><p><a href="{{ extras.album.getDetailUrl(cfgs.nav_item_id) }}"><img class="img-responsive img-rounded" src="{{ filterApply(extras.album.cover_image_id, "medium-thumbnail") }}" border="0" /></a></p>';
    }
}
