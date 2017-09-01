<?php

namespace luya\gallery\frontend\blocks;

use luya\cms\models\NavItem;
use luya\gallery\models\Album;
use luya\cms\base\PhpBlock;

class GalleryAlbum extends PhpBlock
{
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
            'album' => Album::findOne($this->getVarValue('albumId')),
        ];
    }
    
    public function admin()
    {
        return '<p style="padding:20px 0px; font-size:20px;"><i class="fa fa-image fa-2x"></i> Gallery-Album: <strong>{{ extras.album.title }}</strong></p>';
    }
}
