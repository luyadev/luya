<?php

namespace cmsadmin\models;

use Yii;
use yii\helpers\ArrayHelper;
use admin\models\Lang;
use admin\models\Property as AdminProperty;
use cmsadmin\models\Property as CmsProperty;
use cmsadmin\models\NavItem;
use cmsadmin\models\NavItemPageBlockItem;

/**
 * @todo what happens when resort items if an items is deleted?
 *
 * @author nadar
 */
class Nav extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'cms_nav';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeInsert']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'reindex']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'reindex']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'reindex']);
    }

    public function rules()
    {
        return [
            [['nav_container_id', 'parent_nav_id'], 'required'],
            [['is_hidden', 'is_offline', 'sort_index', 'is_deleted', 'is_home', 'is_draft'], 'safe'],
        ];
    }

    public static function findContent($navId)
    {
        $lang = Yii::$app->composition->getKey('langShortCode');
        $langId = Lang::getLangIdByShortCode($lang);
        $item = NavItem::find()->where(['lang_id' => $langId, 'nav_id' => $navId])->one();

        return ($item) ? $item->getContent() : false;
    }

    public function getNavItems()
    {
        return $this->hasMany(NavItem::className(), ['nav_id' => 'id']);
    }

    public function getProperties()
    {
        return CmsProperty::find()->where(['nav_id' => $this->id])->leftJoin('admin_property',
            'admin_prop_id=admin_property.id')->select([
            'cms_nav_property.*',
            'admin_property.module_name',
            'admin_property.class_name',
            'admin_property.var_name'
        ])->asArray()->all();
    }

    /*
    public function getProperty($varName)
    {
        $value = CmsProperty::find()->where(['nav_id' => $this->id])->leftJoin('admin_property', 'admin_prop_id=admin_property.id')->select(['cms_nav_property.value'])->andWhere(['admin_property.var_name' => $varName])->asArray()->one();
        if ($value) {
            return $value['value'];
        } else {
            return false;
        }
    }
    */
    public function getProperty($varName)
    {
        $value = CmsProperty::find()->where(['nav_id' => $this->id])->leftJoin('admin_property',
            'admin_prop_id=admin_property.id')->select([
            'cms_nav_property.value',
            'admin_property.class_name'
        ])->andWhere(['admin_property.var_name' => $varName])->asArray()->one();

        if ($value) {
            return AdminProperty::getObject($value['class_name'], $value['value']);
        }

        return false;
    }

    /**
     * find the latest sort index cms_nav item for the current nav_container_id and parent_nav_id and set internal index count plus one.
     */
    public function eventBeforeInsert()
    {
        $item = self::find()->where([
            'nav_container_id' => $this->nav_container_id,
            'parent_nav_id' => $this->parent_nav_id
        ])->orderBy('sort_index DESC')->limit(1)->asArray()->one();
        if (!$item) {
            $this->sort_index = 1;
        } else {
            $this->sort_index = $item['sort_index'] + 1;
        }
    }

    public function reindex($e)
    {
        $i = 1;
        foreach (self::find()->where([
            'nav_container_id' => $this->nav_container_id,
            'parent_nav_id' => $this->parent_nav_id
        ])->orderBy('sort_index ASC')->asArray()->all() as $model) {
            Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $i], 'id=:id',
                ['id' => $model['id']])->execute();
            ++$i;
        }

        switch ($e->name) {
            case 'afterInsert':
                Log::add(1, "nav.insert, cms_nav.id '" . $this->id . "'", $this->toArray());
                break;
            case 'afterUpdate':
                Log::add(2, "nav.update, cms_nav.id '" . $this->id . "'", $this->toArray());
                break;
            case 'afterDelete':
                Log::add(3, "nav.delete, cms_nav.id '" . $this->id . "'", $this->toArray());
                break;
        }
    }

    public static function moveToContainer($moveNavId, $toCatId)
    {
        $move = self::findOne($moveNavId);

        $move->nav_container_id = $toCatId;
        $move->parent_nav_id = 0;
        $move->update();

        return true;
    }

    /**
     * Check for duplicate alias in same parent_nav_id context of targetNav, comparing with currentNav item.
     * Additional this checks for matching language contexts when comparing aliases.
     *
     * @param $currentNavId
     * @param $targetNav
     * @return bool true when duplicate found
     */
    public static function checkDuplicateAlias($currentNavId, $parentNavId)
    {
        $currentNavItems = NavItem::find()->where(['nav_id' => $currentNavId])->asArray()->all();
        foreach (self::find()->where(['parent_nav_id' => $parentNavId])->andWhere(['<>', 'id', $currentNavId])->asArray()->all() as $item) {
            foreach ($currentNavItems as $currentNavItem) {
                $itemNavItem = NavItem::findOne(['nav_id' => $item['id'], 'lang_id' => $currentNavItem['lang_id']]);
                if ($itemNavItem && $currentNavItem['alias'] == $itemNavItem->alias) {
                    return false;
                }
            }
        }
        return true;
    }

    public static function moveToBefore($moveNavId, $toBeforeNavId)
    {
        $move = self::findOne($moveNavId);
        $to = self::findOne($toBeforeNavId);

        if (!self::checkDuplicateAlias($move->id, $to->parent_nav_id)) {
            return false;
        }

        $to->moveUpstairs();

        $move->nav_container_id = $to->nav_container_id;
        $move->parent_nav_id = $to->parent_nav_id;
        $move->sort_index = $to->sort_index;
        $move->update();

        return true;
    }

    public static function moveToAfter($moveNavId, $toAfterNavId)
    {
        $move = self::findOne($moveNavId);
        $to = self::findOne($toAfterNavId);

        if (!self::checkDuplicateAlias($move->id, $to->parent_nav_id)) {
            return false;
        }

        $to->moveDownstairs();

        $move->nav_container_id = $to->nav_container_id;
        $move->parent_nav_id = $to->parent_nav_id;
        $move->sort_index = $to->sort_index;
        $move->update();

        return true;
    }

    public static function moveToChild($moveNavId, $droppedOnItemId)
    {
        $move = self::findOne($moveNavId);
        $on = self::findOne($droppedOnItemId);

        if (!self::checkDuplicateAlias($move->id, $on->id)) {
            return false;
        }

        $move->nav_container_id = $on->nav_container_id;
        $move->parent_nav_id = $on->id;
        $move->update();

        return true;
    }

    public function moveUpstairs()
    {
        $startIndex = (int)$this->sort_index;
        foreach (self::find()->where('sort_index >= :index', ['index' => $startIndex])->andWhere(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index ASC')->asArray()->all() as $item) {
            ++$startIndex;
            $up = Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $startIndex], 'id=:id',
                ['id' => $item['id']])->execute();
        }
    }

    public function moveDownstairs()
    {
        $startIndex = (int)$this->sort_index;
        foreach (self::find()->where('sort_index >= :index', ['index' => $startIndex])->andWhere(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index ASC')->asArray()->all() as $item) {
            --$startIndex;
            $up = Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $startIndex], 'id=:id',
                ['id' => $item['id']])->execute();
        }
    }

    public function createDraft($title, $langId)
    {
        $_errors = [];

        // nav
        $nav = $this;
        $nav->attributes = [
            'parent_nav_id' => 0,
            'nav_container_id' => 0,
            'sort_index' => 0,
            'is_draft' => 1,
            'is_hidden' => 1,
            'is_offline' => 1
        ];
        // nav item
        $navItem = new NavItem();
        $navItem->parent_nav_id = 0;
        $navItem->attributes = [
            'lang_id' => $langId,
            'nav_item_type' => 4,
            'nav_item_type_id' => 0,
            'title' => $title,
            'alias' => time()
        ];

        if (!$nav->validate()) {
            $_errors = ArrayHelper::merge($nav->getErrors(), $_errors);
        }

        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $nav->save();
        $navItem->nav_id = $nav->id;
        return $navItem->save();
    }
    
    /**
     * 1. find item
     * 2. create a new item (based on the find $navItemId type)
     * 3. copy nav item type data (blocks, layout, or redirects, module, etc.)
     * 
     * @param unknown $navItemId
     * @param unknown $langId
     * @param unknown $title
     * @param unknown $alias
     * @return boolean
     */
    public function createItemLanguageCopy($navItemId, $langId, $title, $alias)
    {
        /*
        $item = NavItem::findOne($navItemId);
        
        $model = new NavItem();
        $model->attributes = $item->toArray();
        $model->title = $title;
        $model->alias = $alias;
        $model->lang_id = $langId;
        
        
        // save
        // copy type (find type)
        // copy content depending on type (blocks for example)
        */
        
        return false;
    }

    public function createPageFromDraft(
        $parentNavId,
        $navContainerId,
        $langId,
        $title,
        $alias,
        $description,
        $fromDraftNavId,
        $isDraft = false
    ) {
        if (!$isDraft && empty($isDraft) && !is_numeric($isDraft)) {
            $isDraft = 0;
        }

        $errors = [];
        // nav
        $nav = $this;
        $nav->attributes = [
            'parent_nav_id' => $parentNavId,
            'nav_container_id' => $navContainerId,
            'is_hidden' => 1,
            'is_offline' => 1,
            'is_draft' => $isDraft
        ];
        // nav item
        $navItem = new NavItem();
        $navItem->parent_nav_id = $parentNavId;
        $navItem->attributes = [
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 1
        ];

        if (!$nav->validate()) {
            $errors = ArrayHelper::merge($nav->getErrors(), $errors);
        }
        if (!$navItem->validate()) {
            $errors = ArrayHelper::merge($navItem->getErrors(), $errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        // get draft nav item data
        $draftNavItem = NavItem::findOne(['nav_id' => $fromDraftNavId]);

        $typeId = $draftNavItem->nav_item_type_id;
        $navItemPageId = $draftNavItem->type->id;
        $layoutId = $draftNavItem->type->layout_id;
        $pageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $navItemPageId]);

        // proceed save process
        $nav->save();
        $navItemPage = new NavItemPage();
        $navItemPage->layout_id = $layoutId;
        $navItemPage->save();
        foreach ($pageBlocks as $block) {
            $i = new NavItemPageBlockItem();
            $i->attributes = $block->toArray();
            $i->nav_item_page_id = $navItemPage->id;
            $i->insert();
        }

        $navItem->nav_id = $nav->id;
        $navItem->nav_item_type_id = $navItemPage->id;

        return $navItem->save();
    }

    public function createPage(
        $parentNavId,
        $navContainerId,
        $langId,
        $title,
        $alias,
        $layoutId,
        $description,
        $isDraft = false
    ) {
        $_errors = [];

        $nav = $this;
        $navItem = new NavItem();
        $navItem->parent_nav_id = $parentNavId;
        $navItemPage = new \cmsadmin\models\NavItemPage();

        if (!$isDraft && empty($isDraft) && !is_numeric($isDraft)) {
            $isDraft = 0;
        }

        $nav->attributes = [
            'parent_nav_id' => $parentNavId,
            'nav_container_id' => $navContainerId,
            'is_hidden' => 1,
            'is_offline' => 1,
            'is_draft' => $isDraft
        ];
        $navItem->attributes = [
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 1
        ];
        $navItemPage->attributes = ['layout_id' => $layoutId];

        if (!$nav->validate()) {
            $_errors = ArrayHelper::merge($nav->getErrors(), $_errors);
        }
        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }
        if (!$navItemPage->validate()) {
            $_errors = ArrayHelper::merge($navItemPage->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $navItemPage->save();
        $nav->save();

        $navItem->nav_item_type_id = $navItemPage->id;
        $navItem->nav_id = $nav->id;
        $navItemId = $navItem->save();

        return $navItemId;
    }

    public function createPageItem($navId, $langId, $title, $alias, $layoutId, $description)
    {
        $_errors = [];

        $navItem = new NavItem();
        $navItem->parent_nav_id = self::findOne($navId)->parent_nav_id;
        $navItemPage = new \cmsadmin\models\NavItemPage();

        $navItem->attributes = [
            'nav_id' => $navId,
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 1
        ];
        $navItemPage->attributes = ['layout_id' => $layoutId];

        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }
        if (!$navItemPage->validate()) {
            $_errors = ArrayHelper::merge($navItemPage->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $navItemPage->save();

        $navItem->nav_item_type_id = $navItemPage->id;
        $navItemId = $navItem->save();

        return $navItemId;
    }

    public function createModule($parentNavId, $navContainerId, $langId, $title, $alias, $moduleName, $description)
    {
        $_errors = [];

        $nav = $this;
        $navItem = new NavItem();
        $navItem->parent_nav_id = $parentNavId;
        $navItemModule = new \cmsadmin\models\NavItemModule();

        $nav->attributes = [
            'parent_nav_id' => $parentNavId,
            'nav_container_id' => $navContainerId,
            'is_hidden' => 1,
            'is_offline' => 1
        ];
        $navItem->attributes = [
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 2
        ];
        $navItemModule->attributes = ['module_name' => $moduleName];

        if (!$nav->validate()) {
            $_errors = ArrayHelper::merge($nav->getErrors(), $_errors);
        }
        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }
        if (!$navItemModule->validate()) {
            $_errors = ArrayHelper::merge($navItemModule->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $navItemModule->save();
        $nav->save();

        $navItem->nav_item_type_id = $navItemModule->id;
        $navItem->nav_id = $nav->id;
        $navItemId = $navItem->save();

        return $navItemId;
    }

    public function createRedirect(
        $parentNavId,
        $navContainerId,
        $langId,
        $title,
        $alias,
        $redirectType,
        $redirectTypeValue,
        $description
    ) {
        $_errors = [];

        $nav = $this;
        $navItem = new NavItem();
        $navItem->parent_nav_id = $parentNavId;
        $navItemRedirect = new \cmsadmin\models\NavItemRedirect();

        $nav->attributes = [
            'parent_nav_id' => $parentNavId,
            'nav_container_id' => $navContainerId,
            'is_hidden' => 1,
            'is_offline' => 1
        ];
        $navItem->attributes = [
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 3
        ];
        $navItemRedirect->attributes = ['type' => $redirectType, 'value' => $redirectTypeValue];

        if (!$nav->validate()) {
            $_errors = ArrayHelper::merge($nav->getErrors(), $_errors);
        }
        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }
        if (!$navItemRedirect->validate()) {
            $_errors = ArrayHelper::merge($navItemRedirect->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $navItemRedirect->save();
        $nav->save();

        $navItem->nav_item_type_id = $navItemRedirect->id;
        $navItem->nav_id = $nav->id;
        $navItemId = $navItem->save();

        return $navItemId;
    }

    public function createModuleItem($navId, $langId, $title, $alias, $moduleName, $description)
    {
        $_errors = [];

        $navItem = new NavItem();
        $navItem->parent_nav_id = self::findOne($navId)->parent_nav_id;
        $navItemModule = new \cmsadmin\models\NavItemModule();

        $navItem->attributes = [
            'nav_id' => $navId,
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 2
        ];
        $navItemModule->attributes = ['module_name' => $moduleName];

        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }
        if (!$navItemModule->validate()) {
            $_errors = ArrayHelper::merge($navItemModule->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $navItemModule->save();

        $navItem->nav_item_type_id = $navItemModule->id;
        $navItemId = $navItem->save();

        return $navItemId;
    }

    public function createRedirectItem($navId, $langId, $title, $alias, $redirectType, $redirectTypeValue, $description)
    {
        $_errors = [];

        $navItem = new NavItem();
        $navItem->parent_nav_id = self::findOne($navId)->parent_nav_id;
        $navItemRedirect = new \cmsadmin\models\NavItemRedirect();

        $navItem->attributes = [
            'nav_id' => $navId,
            'lang_id' => $langId,
            'title' => $title,
            'alias' => $alias,
            'description' => $description,
            'nav_item_type' => 3
        ];
        $navItemRedirect->attributes = ['type' => $redirectType, 'value' => $redirectTypeValue];

        if (!$navItem->validate()) {
            $_errors = ArrayHelper::merge($navItem->getErrors(), $_errors);
        }
        if (!$navItemRedirect->validate()) {
            $_errors = ArrayHelper::merge($navItemRedirect->getErrors(), $_errors);
        }

        if (!empty($_errors)) {
            return $_errors;
        }

        $navItemRedirect->save();

        $navItem->nav_item_type_id = $navItemRedirect->id;
        $navItemId = $navItem->save();

        return $navItemId;
    }
}
