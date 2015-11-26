<?php

namespace cmsadmin\apis;

use cmsadmin\models\NavContainer;
use admin\models\Lang;

class MenuController extends \admin\base\RestController
{
    private $_langShortCode = null;

    public function getLangShortCode()
    {
        if ($this->_langShortCode === null) {
            $array = Lang::getDefault();
            $this->_langShortCode = $array['short_code'];
        }

        return $this->_langShortCode;
    }

    public function actionAll()
    {
        $data = [];
        foreach (NavContainer::find()->asArray()->all() as $container) {
            $data[$container['id']] = [
                'name' => $container['name'],
                'alias' => $container['alias'],
                'id' => $container['id'],
                '__items' => $this->actionGetByContainerAlias($container['alias']),
            ];
        }

        
        // get draft data
        
        $data['drafts'] = $this->getDraftData(Lang::getDefault()['id']);
        
        return $data;
    }
    
    private function getDraftData($langId)
    {
        return (new \yii\db\Query())
        ->select('cms_nav.id, cms_nav.sort_index, cms_nav.parent_nav_id, cms_nav_item.title, cms_nav_item.alias, cms_nav.is_hidden, cms_nav.is_offline, cms_nav.is_home')
        ->from('cms_nav')
        ->leftJoin('cms_nav_item', 'cms_nav.id=cms_nav_item.nav_id')
        ->orderBy('cms_nav.sort_index ASC')
        ->where(['cms_nav_item.lang_id' => $langId, 'cms_nav.is_deleted' => 0, 'cms_nav.is_draft' => 1])
        ->all();
    }

    public function actionGetByContainerAlias($containerAlias)
    {
        $menu = new \cmsadmin\components\Menu();
        $menu->setContainerByAlias($containerAlias);
        $menu->setLangByShortCode($this->getLangShortCode());

        return $menu->childrenRecursive(0, 'nodes');
    }

    public function actionGetByContainerId($containerId)
    {
        $menu = new \cmsadmin\components\Menu();
        $menu->setContainerById($containerId);
        $menu->setLangByShortCode($this->getLangShortCode());

        return $menu->childrenRecursive(0, 'nodes');
    }
}
