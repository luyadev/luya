<?php
namespace cmsadmin\apis;

/**
 * example.com/admin/api-cms-nav/create-page
 * example.com/admin/api-cms-nav/create-item-page
 * example.com/admin/api-cms-nav/create-module
 * example.com/admin/api-cms-nav/create-item-module.
 *
 * @author nadar
 */
class NavController extends \admin\base\RestController
{
    private function postArg($name)
    {
        return \yii::$app->request->post($name, null);
    }

    public function actionToggleHidden($navId)
    {
        $item = \cmsadmin\models\Nav::find()->where(['id' => $navId])->one();
        
        if ($item) {
            $item->is_hidden = (empty($item->is_hidden)) ? 1 : 0;
            $item->update(false);
            return true;
        }
    
        return false;
    }
    
    public function actionDelete($navId)
    {
        $model = \cmsadmin\models\Nav::find()->where(['id' => $navId])->one();
        if ($model) {
            $model->is_deleted = 1;
            return $model->update(false);
        }
    }
    
    public function actionResort()
    {
        $navItemId = $this->postArg('nav_item_id');
        $newSortIndex = $this->postArg('new_sort_index');
        
        $response = \cmsadmin\models\Nav::resort($navItemId, $newSortIndex);
    }
    
    /**
     * creates a new nav entry for the type page (nav_id will be created.
     *
     * @param array $_POST:
     */
    public function actionCreatePage()
    {
        $model = new \cmsadmin\models\Nav();
        $create = $model->createPage($this->postArg('parent_nav_id'), $this->postArg('cat_id'), $this->postArg('lang_id'), $this->postArg('title'), $this->postArg('rewrite'), $this->postArg('layout_id'));

        return $create;
    }

    /**
     * creates a new nav_item entry for the type page (it means nav_id will be delivered).
     */
    public function actionCreatePageItem()
    {
        $model = new \cmsadmin\models\Nav();
        $create = $model->createPageItem($this->postArg('nav_id'), $this->postArg('lang_id'), $this->postArg('title'), $this->postArg('rewrite'), $this->postArg('layout_id'));

        return $create;
    }

    public function actionCreateModule()
    {
        $model = new \cmsadmin\models\Nav();
        $create = $model->createModule($this->postArg('parent_nav_id'), $this->postArg('cat_id'), $this->postArg('lang_id'), $this->postArg('title'), $this->postArg('rewrite'), $this->postArg('module_name'));

        return $create;
    }

    public function actionCreateModuleItem()
    {
        $model = new \cmsadmin\models\Nav();
        $create = $model->createModuleItem($this->postArg('nav_id'), $this->postArg('lang_id'), $this->postArg('title'), $this->postArg('rewrite'), $this->postArg('module_name'));

        return $create;
    }
}
