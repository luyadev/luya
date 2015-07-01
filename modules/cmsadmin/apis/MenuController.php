<?php

namespace cmsadmin\apis;

use cmsadmin\models\Cat;

class MenuController extends \admin\base\RestController
{
    public function actionAll()
    {
        $data = [];
        foreach (Cat::find()->asArray()->all() as $cat) {
            $data[$cat['id']] = [
                'name' => $cat['name'],
                'rewrite' => $cat['rewrite'],
                'id' => $cat['id'],
                'default_nav_id' => $cat['default_nav_id'],
                '__items' => $this->actionGetByCatRewrite($cat['rewrite']),
            ];
        }
        return $data;
    }

    public function actionGetByCatRewrite($catRewrite)
    {
        $menu = new \cmsadmin\components\Menu();
        $menu->setCatByRewrite($catRewrite);
        $menu->setLangByShortCode(\admin\models\Lang::getDefault()->short_code);

        return $menu->childrenRecursive(0, 'nodes');
    }

    public function actionGetByCatId($catId)
    {
        $menu = new \cmsadmin\components\Menu();
        $menu->setCatById($catId);
        $menu->setLangByShortCode(\admin\models\Lang::getDefault()->short_code);

        return $menu->childrenRecursive(0, 'nodes');
    }
}
