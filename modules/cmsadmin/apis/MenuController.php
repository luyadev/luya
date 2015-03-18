<?php
namespace cmsadmin\apis;

class MenuController extends \admin\base\RestController
{
    public function actionAll()
    {
        $data = [];
        foreach(\cmsadmin\models\Cat::find()->all() as $cat) {
            $data[] = [
                "name" => $cat->name,
                "rewrite" => $cat->rewrite,
                "id" => $cat->id,
                "default_nav_id" => $cat->default_nav_id,
                "__items" => $this->actionGetByCatRewrite($cat->rewrite)
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
}
