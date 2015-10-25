<?php

namespace cmsadmin\apis;

use Yii;
use Exception;
use cmsadmin\models\Nav;
use cmsadmin\models\NavItem;

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
        return NavItem::find()->where(['nav_id' => $navId, 'lang_id' => $langId])->asArray()->one();
    }

    public function actionReloadPlaceholder($navItemPageId, $prevId, $placeholderVar)
    {
        return $this->getSub($placeholderVar,  (int) $navItemPageId, (int) $prevId);
    }

    public function actionTypeData($navItemId)
    {
        return NavItem::findOne($navItemId)->getType()->toArray();
    }

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
            throw new Exception('Unable to find item id ' . $navItemId);
        }
        $model->setParentFromModel();
        $model->attributes = Yii::$app->request->post();;
        $v = $model->validate();
        if ($model->validate()) {
            if ($model->save()) {
                return true;
            }
        }

        return $this->sendModelError($model);
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

    public function actionMoveBefore($moveItemId, $droppedBeforeItemId)
    {
        return ['success' => Nav::moveToBefore($moveItemId, $droppedBeforeItemId)];
    }

    public function actionMoveAfter($moveItemId, $droppedAfterItemId)
    {
        return ['success' => Nav::moveToAfter($moveItemId, $droppedAfterItemId)];
    }

    public function actionMoveToChild($moveItemId, $droppedOnItemId)
    {
        return ['success' => Nav::moveToChild($moveItemId, $droppedOnItemId)];
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
            'id' => $blockItem['id'],
            'name' => $blockObject->name(),
            'icon' => $blockObject->icon(),
            'full_name' => $blockObject->getFullName(),
            'twig_admin' => $blockObject->twigAdmin(),
            'vars' => $blockObject->getVars(),
            'cfgs' => $blockObject->getCfgs(),
            'extras' => $blockObject->extraVars(),
            'values' => $blockItem['json_config_values'],
            'cfgvalues' => $blockItem['json_config_cfg_values'], // add: t1_json_config_cfg_values
            '__placeholders' => $placeholders,
        ];
    }
}
