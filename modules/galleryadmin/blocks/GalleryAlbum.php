<?php

namespace galleryadmin\blocks;

class GalleryAlbum extends \cmsadmin\base\Block
{
    public $module = 'gallery';
    
    private $_dropdown = [];

    private $_alben = [];

    public function init()
    {
        foreach (\cmsadmin\models\NavItem::fromModule('gallery') as $item) {
            $this->_dropdown[] = ['value' => $item->id, 'label' => $item->title];
        }

        foreach (\galleryadmin\models\Album::find()->asArray()->all() as $item) {
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
                ['var' => 'albumId', 'label' => 'Album', 'type' => 'zaa-input-select', 'options' => $this->_alben],
            ],
            'cfgs' => [
                ['var' => 'nav_item_id', 'label' => 'Gallery für Albumansicht', 'type' => 'zaa-input-select', 'options' => $this->_dropdown],
            ],
        ];
    }

    public function extraVars()
    {
        return [
            'album' => \galleryadmin\models\Album::find()->where(['id' => $this->getVarValue('albumId')])->one(),
        ];
    }

    public function twigAdmin()
    {
        return '<p style="padding:20px 0px; font-size:20px;"><i class="fa fa-image fa-2x"></i> Gallery-Album: <strong>{{ extras.album.title }}</strong></p>';
    }

    public function twigFrontend()
    {
        return '<div class="well"><h3>{{ extras.album.title }}</h3><p>{{ extras.album.description }}</p><p><img src="{{ filterApply(extras.album.cover_image_id, "medium-thumbnail") }}" border="0" /></p><p><a href="{{ extras.album.getDetailUrl(cfgs.nav_item_id) }}">GO TO</a></p></div>';
    }
}
