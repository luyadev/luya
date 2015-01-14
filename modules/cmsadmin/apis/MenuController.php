<?php
namespace cmsadmin\apis;

/**
 * @todo set default catId and langId
 * @author nadar
 *
 */
class MenuController extends \admin\base\RestVerbController
{
    use \admin\base\RestTrait;

    public function actionIndex()
    {
        $menu = new \cmsadmin\components\Menu();
        $menu->setCatByRewrite('default');
        $menu->setLangByShortCode('de');

        return $menu->childrenRecursive(0, 'nodes');
    }

    public function actionView($id)
    {
        $menu = new \cmsadmin\components\Menu();
        $menu->setCatByRewrite('default');
        $menu->setLangByShortCode('de');

        return $menu->children($id);
    }
}
