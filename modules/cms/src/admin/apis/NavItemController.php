<?php

namespace luya\cms\admin\apis;

use luya\cms\models\NavContainer;
use luya\cms\models\NavItemModule;
use luya\cms\models\NavItemPage;
use luya\cms\models\NavItemRedirect;
use Yii;
use Exception;
use luya\cms\models\Nav;
use luya\cms\models\NavItem;
use luya\cms\models\NavItemPageBlockItem;
use luya\web\filters\ResponseCache;
use yii\caching\DbDependency;
use luya\cms\models\Layout;

/**
 * NavItem Api is cached response method to load data and perform changes of cms nav item.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class NavItemController extends \luya\admin\base\RestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        
        $behaviors['responseCache'] = [
            'class' => ResponseCache::className(),
            'actions' => ['nav-lang-item'],
            'variations' => [
                Yii::$app->request->get('navId', 0),
                Yii::$app->request->get('langId', 0),
            ],
            'dependency' => [
                'class' => DbDependency::className(),
                'sql' => 'SELECT timestamp_update FROM cms_nav_item WHERE lang_id=:lang_id AND nav_id=:nav_id',
                'params' => [':lang_id' => Yii::$app->request->get('langId', 0), ':nav_id' => Yii::$app->request->get('navId', 0)]
            ]
        ];
        
        return $behaviors;
    }
    
    /**
     * http://example.com/admin/api-cms-navitem/nav-lang-item?access-token=XXX&navId=A&langId=B.
     *
     * @param unknown_type $navId
     * @param unknown_type $langId
     *
     * @return multitype:unknown
     */
    public function actionNavLangItem($navId, $langId)
    {
        $item = NavItem::find()->where(['nav_id' => $navId, 'lang_id' => $langId])->one();
        if ($item) {
            return [
                'error' => false,
                'item' => $item->toArray(),
                'typeData' => ($item->nav_item_type == 1) ? NavItemPage::getVersionList($item->id) : $item->getType()->toArray(),
            ];
        }
        
        return ['error' => true];
    }

    public function actionReloadPlaceholder($navItemPageId, $prevId, $placeholderVar)
    {
        return NavItemPage::getPlaceholder($placeholderVar, (int) $navItemPageId, (int) $prevId);
    }

    public function actionUpdateItemTypeData($navItemId)
    {
        return NavItem::findOne($navItemId)->updateType(Yii::$app->request->post());
    }
    
    public function actionChangePageVersionLayout()
    {
        $pageItemId = Yii::$app->request->post('pageItemId');
        $layoutId = Yii::$app->request->post('layoutId');
        $alias = Yii::$app->request->post('alias');

        $model = NavItemPage::findOne(['id' => $pageItemId]);
        
        if ($model) {
            $model->forceNavItem->updateTimestamp();
            return $model->updateAttributes(['layout_id' => $layoutId, 'version_alias' => $alias]);
        }
        
        return false;
    }
    
    public function actionRemovePageVersion()
    {
        $pageId = Yii::$app->request->getBodyParam('pageId');
        
        $page = NavItemPage::findOne($pageId);
        
        if ($page) {
            $page->forceNavItem->updateTimestamp();
            $page->delete();
        }
    }
    
    /**
     * Create a new cms_nv_item_page for an existing nav_item, this is also known as a "new version" of a page item.
     *
     */
    public function actionCreatePageVersion()
    {
        $name = Yii::$app->request->post('name');
        $fromPageId = Yii::$app->request->post('fromPageId');
        $navItemId = Yii::$app->request->post('navItemId');
        $layoutId = Yii::$app->request->post('layoutId');
        
        if (empty($name) || empty($navItemId)) {
            return ['error' => true];
        }
        
        if (empty($fromPageId) && empty($layoutId)) {
            return ['error' => true];
        }
        
        $navItemModel = NavItem::findOne($navItemId);
        
        if (!$navItemModel) {
            throw new \luya\Exception("Unable to find nav item model");
        }
        
        if (!empty($fromPageId)) {
            $fromPageModel = NavItemPage::findOne($fromPageId);
            $layoutId = $fromPageModel->layout_id;
        }
        
        $model = new NavItemPage();
        $model->attributes = [
            'nav_item_id' => $navItemId,
            'timestamp_create' => time(),
            'create_user_id' => Yii::$app->adminuser->getId(),
            'version_alias' => $name,
            'layout_id' => $layoutId,
        ];
        
        $save = $model->save(false);
        
        if (!empty($fromPageId) && $save) {
            NavItemPage::copyBlocks($fromPageModel->id, $model->id);
        }
        
        if (empty($navItemModel->nav_item_type_id) && $navItemModel->nav_item_type == 1) {
            $navItemModel->updateAttributes(['nav_item_type_id' => $model->id]);
        }
        
        $navItemModel->updateAttributes(['timestamp_update' => time()]);
        
        return ['error' => !$save];
    }
    
    /**
     * admin/api-cms-navitem/update-item?navItemId=2.
     *
     * @param unknown_type $navItemId
     *
     * @return unknown
     */
    public function actionUpdateItem($navItemId)
    {
        $model = NavItem::find()->where(['id' => $navItemId])->one();

        if (!$model) {
            throw new Exception('Unable to find item id '.$navItemId);
        }
        $model->setParentFromModel();
        $model->attributes = Yii::$app->request->post();
        $model->timestamp_update = time();
        if ($model->validate()) {
            if ($model->save()) {
                return true;
            }
        }

        return $this->sendModelError($model);
    }

    /**
     * delete specific nav item info (page/module/redirect).
     *
     * @param $navItemType
     * @param $navItemTypeId
     */
    /*
    public function deleteItem($navItemType, $navItemTypeId)
    {
        $model = null;
        switch ($navItemType) {
            case 1:
                $model = NavItemPage::find()->where(['id' => $navItemTypeId])->one();
                break;
            case 2:
                $model = NavItemModule::find()->where(['id' => $navItemTypeId])->one();
                break;
            case 3:
                $model = NavItemRedirect::find()->where(['id' => $navItemTypeId])->one();
                break;
        }
        if ($model) {
            $model->delete();
        }
    }
    */

    /**
     * extract a post var and set to model attribute with the same name.
     *
     * @param $model
     * @param string $attribute
     */
    public function setPostAttribute($model, $attribute)
    {
        if ($attributeValue = Yii::$app->request->post($attribute, null)) {
            $model->setAttribute($attribute, $attributeValue);
        }
    }

    /**
     * check old entries - delete if obsolete (changed type) and add new entry to the appropriate cms_nav_item_(page/module/redirect).
     *
     * @param integer The id of the nav_item item which should be changed
     * @param integer The NEW type of content for the above nav_item.id
     * @return array|bool
     */
    public function actionUpdatePageItem($navItemId, $navItemType)
    {
        $model = NavItem::findOne($navItemId);
        
        if (!$model) {
            throw new Exception('Unable to find the requested nav item object.');
        }
        
        $model->setParentFromModel();
        $model->title = Yii::$app->request->post('title', false);
        $model->alias = Yii::$app->request->post('alias', false);
        $model->description = Yii::$app->request->post('description', null);
        $model->keywords = Yii::$app->request->post('keywords');

        // make sure the currently provided informations are valid (like title);
        if (!$model->validate()) {
            return $this->sendModelError($model);
        }
      
        if ($model->nav_item_type == $navItemType) {
            $typeModel = $model->getType();
            // lets just update the type data
            switch ($navItemType) {
                case 1:
                    $this->setPostAttribute($model, 'nav_item_type_id');
                    break;
                case 2:
                    $this->setPostAttribute($typeModel, 'module_name');
                    if (!$typeModel->validate()) {
                        return $this->sendModelError($typeModel);
                    }
                    $typeModel->update();
                    break;
                case 3:
                    $this->setPostAttribute($typeModel, 'type');
                    $this->setPostAttribute($typeModel, 'value');
                    if (!$typeModel->validate()) {
                        return $this->sendModelError($typeModel);
                    }
                    $typeModel->update();
                    break;
            }
            // store updated type model and nav item model!
            return $model->save();
        } else {
            // complety switch the type of this item (delete old type)
            $oldType = $model->getType();
            // set the new type
            $model->nav_item_type = $navItemType;
            switch ($navItemType) {
                case 1:
                    if ($oldType) {
                        $oldType->delete();
                    }
                    $model->nav_item_type_id = 0;
                    return $model->update();
                case 2:
                    $typeModel = new NavItemModule();
                    $this->setPostAttribute($typeModel, 'module_name');
                    if (!$typeModel->validate()) {
                        return $this->sendModelError($typeModel);
                    }
                    if ($oldType) {
                        $oldType->delete();
                    }
                    $typeModel->insert();
                    $model->nav_item_type_id = $typeModel->id;
                    return $model->update();
                    break;
                case 3:
                    $typeModel = new NavItemRedirect();
                    $this->setPostAttribute($typeModel, 'type');
                    $this->setPostAttribute($typeModel, 'value');
                    if (!$typeModel->validate()) {
                        return $this->sendModelError($typeModel);
                    }
                     if ($oldType) {
                         $oldType->delete();
                     }
                    $typeModel->insert();
                    $model->nav_item_type_id = $typeModel->id;
                    return $model->update();
                    break;
            }
        }
        
        return false;
    }

    /**
     * returns all the PAGE type specific informations.
     */
    public function actionTypePageContainer($navItemId)
    {
        $navItem = NavItem::findOne($navItemId);
        $type = $navItem->getType();
        $layout = Layout::findOne($type->layout_id);
        if (!empty($layout)) {
            $layout->json_config = json_decode($layout->json_config, true);
        }

        return [
            //'nav_item' => $navItem,
            'layout' => $layout,
            'type_container' => $type,
        ];
    }

    public function actionMoveToContainer($moveItemId, $droppedOnCatId)
    {
        return ['success' => Nav::moveToContainer($moveItemId, $droppedOnCatId)];
    }

    public function actionMoveBefore($moveItemId, $droppedBeforeItemId)
    {
        $result = Nav::moveToBefore($moveItemId, $droppedBeforeItemId);
        
        if ($result !== true) {
            Yii::$app->response->setStatusCode(422, 'Found URL alias duplication in drop target "'.$result['title'].'".');
        }
        return ['success' => $result];
    }

    public function actionMoveAfter($moveItemId, $droppedAfterItemId)
    {
        $result = Nav::moveToAfter($moveItemId, $droppedAfterItemId);
        
        if ($result !== true) {
            Yii::$app->response->setStatusCode(422, 'Found URL alias duplication in drop target "'.$result['title'].'".');
        }
        return ['success' => $result];
    }

    public function actionMoveToChild($moveItemId, $droppedOnItemId)
    {
        $result = Nav::moveToChild($moveItemId, $droppedOnItemId);
        
        if ($result !== true) {
            Yii::$app->response->setStatusCode(422, 'Found URL alias duplication in drop target "'.$result['title'].'".');
        }
        return ['success' => $result];
    }

    /*
    public function actionGetBlock($blockId)
    {
        return NavItemPage::getBlock($blockId);
    }
    */
    
    public function actionToggleBlockHidden($blockId, $hiddenState)
    {
        $block = NavItemPageBlockItem::findOne($blockId);
        if ($block) {
            $block->is_hidden = $hiddenState;
            return $block->update(false);
        }
        
        return false;
    }

    /**
     * Get full constructed of a nav item.
     *
     * @param $navId
     * @return string Path
     */
    public function actionGetNavItemPath($navId)
    {
        $data = "";
        $node = NavItem::find()->where(['nav_id' => $navId])->one();
        if ($node) {
            $data .= $node->title;
            $parentNavId = $navId;
            while ($parentNavId != 0) {
                $parentNavId = Nav::findOne($parentNavId)->parent_nav_id;
                if ($parentNavId != 0) {
                    $node = NavItem::find()->where(['nav_id' => $parentNavId])->one();
                    if ($parentNavId) {
                        $data = $node->title . '/' . $data;
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Get Container name for a nav item.
     *
     * @param $navId
     * @return string Container name
     */
    public function actionGetNavContainerName($navId)
    {
        $nav = Nav::findOne($navId);
        if ($nav) {
            $navCoontainer = NavContainer::findOne($nav->nav_container_id);
            if ($navCoontainer) {
                return $navCoontainer->name;
            }
        }
        return "";
    }
}
