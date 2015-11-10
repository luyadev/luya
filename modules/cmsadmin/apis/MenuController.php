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

        return $data;
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
