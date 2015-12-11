<?php

namespace cmsadmin\apis;

use cmsadmin\models\NavContainer;
use cmsadmin\models\NavItemModule;
use cmsadmin\models\NavItemPage;
use cmsadmin\models\NavItemRedirect;
use Yii;
use Exception;
use cmsadmin\models\Nav;
use cmsadmin\models\NavItem;
use cmsadmin\models\NavItemPageBlockItem;

class NavItemController extends \admin\base\RestController
{
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
                'typeData' => $item->getType()->toArray(),
                'tree' => ($item->nav_item_type == 1) ? $this->actionTree($item->getType()->id) : false,
            ];
        }
        
        return ['error' => true];
    }

    public function actionReloadPlaceholder($navItemPageId, $prevId, $placeholderVar)
    {
        return $this->getSub($placeholderVar, (int) $navItemPageId, (int) $prevId);
    }

    /*
    public function actionTypeData($navItemId)
    {
        return NavItem::findOne($navItemId)->getType()->toArray();
    }
    */

    public function actionUpdateItemTypeData($navItemId)
    {
        return NavItem::findOne($navItemId)->updateType(Yii::$app->request->post());
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
     * @param $navItemId
     * @param $navItemType
     * @param $navItemTypeId
     * @param $title
     * @param $alias
     *
     * @return array|bool
     */
    public function actionUpdatePageItem($navItemId, $navItemType, $navItemTypeId)
    {
        $model = NavItem::find()->where(['id' => $navItemId])->one();
        if (!$model) {
            throw new Exception('Unable to find item id '.$navItemId);
        }
        $model->setParentFromModel();
        // save old id
        $oldNavItemType = $model->nav_item_type;
        $oldNavItemTypeId = $model->nav_item_type_id;
        $oldTitle = $model->title;
        $oldAlias = $model->alias;

        $model->nav_item_type = $navItemType;
        $model->title = Yii::$app->request->post('title', false);
        $model->alias = Yii::$app->request->post('alias', false);
        $model->description = Yii::$app->request->post('description', null);

        if ((!$model->validate()) || (!$model->save())) {
            return $this->sendModelError($model);
        }

        $itemModel = null;
        if ($oldNavItemType == $model->nav_item_type) {
            switch ($navItemType) {
                case 1:
                    $itemModel = NavItemPage::find()->where(['id' => $navItemTypeId])->one();
                    break;
                case 2:
                    $itemModel = NavItemModule::find()->where(['id' => $navItemTypeId])->one();
                    break;
                case 3:
                    $itemModel = NavItemRedirect::find()->where(['id' => $navItemTypeId])->one();
                    break;
            }
        } else {
            switch ($navItemType) {
                case 1:
                    $itemModel = new NavItemPage();
                    break;
                case 2:
                    $itemModel = new NavItemModule();
                    break;
                case 3:
                    $itemModel = new NavItemRedirect();
                    break;
            }
        }

        switch ($navItemType) {
            case 1:
                $this->setPostAttribute($itemModel, 'layout_id');
                break;
            case 2:
                $this->setPostAttribute($itemModel, 'module_name');
                break;
            case 3:
                $this->setPostAttribute($itemModel, 'type');
                $this->setPostAttribute($itemModel, 'value');
                break;
        }

        if ((!$itemModel->validate()) || (!$itemModel->save())) {
            // error: reverse changes in nav item
            $model->nav_item_type = $oldNavItemType;
            $model->nav_item_type_id = $oldNavItemTypeId;
            $model->alias = $oldAlias;
            $model->title = $oldTitle;
            $model->update(false);

            return $this->sendModelError($itemModel);
        }

        if ($oldNavItemType != $model->nav_item_type) {
            $this->deleteItem($oldNavItemType, $oldNavItemTypeId);
        }

        // save new type id
        $model->nav_item_type_id = $itemModel->id;
        $model->update(false);

        return true;
    }

    /**
     * returns all the PAGE type specific informations.
     */
    public function actionTypePageContainer($navItemId)
    {
        $navItem = NavItem::findOne($navItemId);
        $type = $navItem->getType();
        $layout = \cmsadmin\models\Layout::findOne($type->layout_id);
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
        if (!$result = Nav::moveToBefore($moveItemId, $droppedBeforeItemId)) {
            Yii::$app->response->setStatusCode(422, 'Found URL alias duplication in target parent nav id.');
        }
        return ['success' => $result];
    }

    public function actionMoveAfter($moveItemId, $droppedAfterItemId)
    {
        if (!$result = Nav::moveToAfter($moveItemId, $droppedAfterItemId)) {
            Yii::$app->response->setStatusCode(422, 'Found URL alias duplication in target parent nav id.');
        }
        return ['success' => $result];
    }

    public function actionMoveToChild($moveItemId, $droppedOnItemId)
    {
        if (!$result = Nav::moveToChild($moveItemId, $droppedOnItemId)) {
            Yii::$app->response->setStatusCode(422, 'Found URL alias duplication in target parent nav id.');
        }
        return ['success' => $result];
    }

    /**
     * RECUSRION.
     */
    public function actionTree($navItemPageId)
    {
        $nav_item_page = (new \yii\db\Query())->select('*')->from('cms_nav_item_page t1')->leftJoin('cms_layout', 'cms_layout.id=t1.layout_id')->where(['t1.id' => $navItemPageId])->one();

        $return = [
            'nav_item_page' => ['id' => $nav_item_page['id'], 'layout_id' => $nav_item_page['layout_id'], 'layout_name' => $nav_item_page['name']],
            '__placeholders' => [],
        ];

        $nav_item_page['json_config'] = json_decode($nav_item_page['json_config'], true);

        if (isset($nav_item_page['json_config']['placeholders'])) {
            foreach ($nav_item_page['json_config']['placeholders'] as $placeholderKey => $placeholder) {
                $placeholder['nav_item_page_id'] = $navItemPageId;
                $placeholder['prev_id'] = 0;
                $placeholder['__nav_item_page_block_items'] = [];

                $return['__placeholders'][$placeholderKey] = $placeholder;

                $placeholderVar = $placeholder['var'];

                $return['__placeholders'][$placeholderKey]['__nav_item_page_block_items'] = $this->getSub($placeholderVar, $navItemPageId, 0);
            }
        }

        return $return;
    }

    public function actionGetBlock($blockId)
    {
        return $this->getBlock($blockId);
    }

    private function getSub($placeholderVar, $navItemPageId, $prevId)
    {
        /*
        $nav_item_page_block_item_data = (new \yii\db\Query())->select([
                't1_id' => 't1.id', 't1.is_dirty', 'block_id', 't1_nav_item_page_id' => 't1.nav_item_page_id', 't1_json_config_values' => 't1.json_config_values', 't1_json_config_cfg_values' => 't1.json_config_cfg_values', 't1_placeholder_var' => 't1.placeholder_var', 't1_prev_id' => 't1.prev_id',
                //'t2_id' => 't2.id', 't2_name' => 't2.name', 't2_json_config' => 't2.json_config', 't2_twig_admin' => 't2.twig_admin',
        ])->from('cms_nav_item_page_block_item t1')->orderBy('t1.sort_index ASC')->where(['t1.prev_id' => $prevId, 't1.nav_item_page_id' => $navItemPageId, 't1.placeholder_var' => $placeholderVar])->all();
        */

        $nav_item_page_block_item_data = (new \yii\db\Query())->select(['id'])->from('cms_nav_item_page_block_item')->orderBy('sort_index ASC')->where(['prev_id' => $prevId, 'nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar])->all();

        $data = [];

        foreach ($nav_item_page_block_item_data as $blockItem) {
            $block = $this->getBlock($blockItem['id']);
            if ($block) {
                $data[] = $block;
            }
        }

        return $data;
    }

    private function getBlock($blockId)
    {
        $blockItem = (new \yii\db\Query())->select('*')->from('cms_nav_item_page_block_item')->where(['id' => $blockId])->one();

        $blockObject = \cmsadmin\models\Block::objectId($blockItem['block_id'], $blockItem['id'], 'admin', NavItem::findOne($blockItem['nav_item_page_id']));
        if ($blockObject === false) {
            return false;
        }

        $blockItem['json_config_values'] = json_decode($blockItem['json_config_values'], true);
        $blockItem['json_config_cfg_values'] = json_decode($blockItem['json_config_cfg_values'], true);

        $blockValue = $blockItem['json_config_values'];
        $blockCfgValue = $blockItem['json_config_cfg_values'];

        $blockObject->setVarValues((empty($blockValue)) ? [] : $blockValue);
        $blockObject->setCfgValues((empty($blockCfgValue)) ? [] : $blockCfgValue);

        $placeholders = [];

        foreach ($blockObject->getPlaceholders() as $pk => $pv) {
            $pv['nav_item_page_id'] = $blockItem['nav_item_page_id'];
            $pv['prev_id'] = $blockItem['id'];
            $placeholderVar = $pv['var'];

            $pv['__nav_item_page_block_items'] = $this->getSub($placeholderVar, $blockItem['nav_item_page_id'], $blockItem['id']);

            $placeholder = $pv;

            $placeholders[] = $placeholder;
        }

        if (empty($blockItem['json_config_values'])) {
            $blockItem['json_config_values'] = new \stdClass();
        }

        if (empty($blockItem['json_config_cfg_values'])) {
            $blockItem['json_config_cfg_values'] = new \stdClass();
        }

        return [
            'is_dirty' => (int) $blockItem['is_dirty'],
            'is_container' => (int) $blockObject->isContainer,
            'id' => $blockItem['id'],
            'is_hidden' => $blockItem['is_hidden'],
            'name' => $blockObject->name(),
            'icon' => $blockObject->icon(),
            'full_name' => $blockObject->getFullName(),
            'twig_admin' => $blockObject->twigAdmin(),
            'vars' => $blockObject->getVars(),
            'cfgs' => $blockObject->getCfgs(),
            'extras' => $blockObject->extraVars(),
            'values' => $blockItem['json_config_values'],
            'field_help' => $blockObject->getFieldHelp(),
            'cfgvalues' => $blockItem['json_config_cfg_values'], // add: t1_json_config_cfg_values
            '__placeholders' => $placeholders,
        ];
    }
    
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
