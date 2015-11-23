<?php

namespace cmsadmin\models;

use Yii;
use yii\helpers\ArrayHelper;
use admin\models\Lang;
use admin\models\Property as AdminProperty;
use cmsadmin\models\Property as CmsProperty;

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
            [['is_hidden', 'is_offline', 'sort_index', 'is_deleted', 'is_home'], 'safe'],
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
        return CmsProperty::find()->where(['nav_id' => $this->id])->leftJoin('admin_property', 'admin_prop_id=admin_property.id')->select(['cms_nav_property.*', 'admin_property.module_name', 'admin_property.class_name', 'admin_property.var_name'])->asArray()->all();
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
        $value = CmsProperty::find()->where(['nav_id' => $this->id])->leftJoin('admin_property', 'admin_prop_id=admin_property.id')->select(['cms_nav_property.value', 'admin_property.class_name'])->andWhere(['admin_property.var_name' => $varName])->asArray()->one();

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
        $item = self::find()->where(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index DESC')->limit(1)->asArray()->one();
        if (!$item) {
            $this->sort_index = 1;
        } else {
            $this->sort_index = $item['sort_index'] + 1;
        }
    }

    public function reindex($e)
    {
        $i = 1;
        foreach (self::find()->where(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index ASC')->asArray()->all() as $model) {
            Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $i], 'id=:id', ['id' => $model['id']])->execute();
            ++$i;
        }

        switch ($e->name) {
            case 'afterInsert':
                Log::add(1, "nav.insert, cms_nav.id '".$this->id."'", $this->toArray());
            break;
            case 'afterUpdate':
                Log::add(2, "nav.update, cms_nav.id '".$this->id."'", $this->toArray());
                break;
            case 'afterDelete':
                Log::add(3, "nav.delete, cms_nav.id '".$this->id."'", $this->toArray());
                break;
        }
    }

    public static function moveToBefore($moveNavId, $toBeforeNavId)
    {
        $move = self::findOne($moveNavId);
        $to = self::findOne($toBeforeNavId);

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

        $move->nav_container_id = $on->nav_container_id;
        $move->parent_nav_id = $on->id;
        $move->update();

        return true;
    }

    public function moveUpstairs()
    {
        $startIndex = (int) $this->sort_index;
        foreach (self::find()->where('sort_index >= :index', ['index' => $startIndex])->andWhere(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index ASC')->asArray()->all() as $item) {
            ++$startIndex;
            $up = Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $startIndex], 'id=:id', ['id' => $item['id']])->execute();
        }
    }

    public function moveDownstairs()
    {
        $startIndex = (int) $this->sort_index;
        foreach (self::find()->where('sort_index >= :index', ['index' => $startIndex])->andWhere(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index ASC')->asArray()->all() as $item) {
            --$startIndex;
            $up = Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $startIndex], 'id=:id', ['id' => $item['id']])->execute();
        }
    }

    public function createPage($parentNavId, $navContainerId, $langId, $title, $alias, $layoutId, $description)
    {
        $_errors = [];

        $nav = $this;
        $navItem = new NavItem();
        $navItem->parent_nav_id = $parentNavId;
        $navItemPage = new \cmsadmin\models\NavItemPage();

        $nav->attributes = ['parent_nav_id' => $parentNavId, 'nav_container_id' => $navContainerId, 'is_hidden' => 1, 'is_offline' => 1];
        $navItem->attributes = ['lang_id' => $langId, 'title' => $title, 'alias' => $alias, 'description' => $description, 'nav_item_type' => 1];
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

        $navItem->attributes = ['nav_id' => $navId, 'lang_id' => $langId, 'title' => $title, 'alias' => $alias, 'description' => $description, 'nav_item_type' => 1];
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

        $nav->attributes = ['parent_nav_id' => $parentNavId, 'nav_container_id' => $navContainerId, 'is_hidden' => 1, 'is_offline' => 1];
        $navItem->attributes = ['lang_id' => $langId, 'title' => $title, 'alias' => $alias, 'description' => $description, 'nav_item_type' => 2];
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

    public function createRedirect($parentNavId, $navContainerId, $langId, $title, $alias, $redirectType, $redirectTypeValue, $description)
    {
        $_errors = [];

        $nav = $this;
        $navItem = new NavItem();
        $navItem->parent_nav_id = $parentNavId;
        $navItemRedirect = new \cmsadmin\models\NavItemRedirect();

        $nav->attributes = ['parent_nav_id' => $parentNavId, 'nav_container_id' => $navContainerId, 'is_hidden' => 1, 'is_offline' => 1];
        $navItem->attributes = ['lang_id' => $langId, 'title' => $title, 'alias' => $alias, 'description' => $description, 'nav_item_type' => 3];
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

        $navItem->attributes = ['nav_id' => $navId, 'lang_id' => $langId, 'title' => $title, 'alias' => $alias, 'description' => $description, 'nav_item_type' => 2];
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

        $navItem->attributes = ['nav_id' => $navId, 'lang_id' => $langId, 'title' => $title, 'alias' => $alias, 'description' => $description, 'nav_item_type' => 3];
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
