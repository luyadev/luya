<?php

namespace cmsadmin\models;

use Yii;
use yii\helpers\ArrayHelper;
use admin\models\Lang;
use admin\models\Property as AdminProperty;
use cmsadmin\models\Property as CmsProperty;
use cmsadmin\models\NavItem;
use cmsadmin\models\NavItemPageBlockItem;
use cmsadmin\Module;

/**
 * CMS Nav Model ActiveRecord
 * 
 * This is the main class for the cms navigation/menu structure. The Nav item contains information about the state of the page like visibility,
 * sort-index, online or offline. It also contains information about its a child of another nav element, but it does **NOT** contain informations
 * about the content, title or alias (link) itself, cause those informations are stored in the the [[\cmsadmin\models\NavItem]] to the corresponding
 * language. So basically the Nav contains the structure and state of the menu/navigation put not content, or titles cause those are related to a language.
 * 
 * 
 * @property \cmsadmin\models\NavItem $activeLanguageItem Returns the NavItem for the current active user language with with the context object nav id.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::tableName()
     */
    public static function tableName()
    {
        return 'cms_nav';
    }

    /**
     * {@inheritDoc}
     * @see \yii\db\BaseActiveRecord::init()
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeInsert']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'reindex']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'reindex']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'reindex']);
    }

    /**
     * {@inheritDoc}
     * @see \yii\base\Model::rules()
     */
    public function rules()
    {
        return [
            [['nav_container_id', 'parent_nav_id'], 'required'],
            [['is_hidden', 'is_offline', 'sort_index', 'is_deleted', 'is_home', 'is_draft'], 'safe'],
        ];
    }

    /**
     * Get the cms_nav_item for this nav object with the corresponding current active language id (based
     * on the composition component).
     * 
     * @return \cmsadmin\models\NavItem The corresponding nav item object for the active language.
     */
    public function getActiveLanguageItem()
    {
        return $this->hasOne(NavItem::className(), ['nav_id' => 'id'])->andWhere(['lang_id' => Yii::$app->adminLanguage->activeId]);
    }

    /**
     * Return all nav items related to this object.
     * 
     * @return \yii\db\ActiveQuery
     */
    public function getNavItems()
    {
        return $this->hasMany(NavItem::className(), ['nav_id' => 'id']);
    }

    private $_properties = null;
    
    /**
     * 
     */
    public function getProperties()
    {
        if ($this->_properties === null) {
            $this->_properties = CmsProperty::find()->where(['nav_id' => $this->id])->with('adminProperty')->all();
        }
        
        return $this->_properties;
    }
    
    /**
     * 
     * @param unknown $varName
     * @return boolean
     */
    public function getProperty($varName)
    {
        foreach ($this->getProperties() as $prop) {
            if ($prop->adminProperty->var_name == $varName) {
                return $prop->getObject();
            }
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

    // static helpers to move and copie

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
     * @return boolean|mixed returns `true` if no duplication has been found, otherwhise returns an array with the duplicated existing item.
     */
    public static function checkDuplicateAlias($currentNavId, $parentNavId)
    {
        $currentNavItems = NavItem::find()->where(['nav_id' => $currentNavId])->asArray()->all();
        foreach (self::find()->where(['parent_nav_id' => $parentNavId, 'is_deleted' => 0])->andWhere(['<>', 'id', $currentNavId])->asArray()->all() as $item) {
            foreach ($currentNavItems as $currentNavItem) {
                $itemNavItem = NavItem::find()->asArray()->where(['nav_id' => $item['id'], 'lang_id' => $currentNavItem['lang_id']])->one();
                if ($itemNavItem && $currentNavItem['alias'] == $itemNavItem['alias']) {
                    return $itemNavItem;
                }
            }
        }
        return true;
    }

    public static function moveToBefore($moveNavId, $toBeforeNavId)
    {
        $move = self::findOne($moveNavId);
        $to = self::findOne($toBeforeNavId);

        $response = self::checkDuplicateAlias($move->id, $to->parent_nav_id);
        
        if ($response !== true) {
            return $response;
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

        $response = self::checkDuplicateAlias($move->id, $to->parent_nav_id);
        
        if ($response !== true) {
            return $response;
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


        $response = self::checkDuplicateAlias($move->id, $on->id);
        
        if ($response !== true) {
            return $response;
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
            Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $startIndex], 'id=:id', ['id' => $item['id']])->execute();
        }
    }

    public function moveDownstairs()
    {
        $startIndex = (int)$this->sort_index;
        foreach (self::find()->where('sort_index >= :index', ['index' => $startIndex])->andWhere(['nav_container_id' => $this->nav_container_id, 'parent_nav_id' => $this->parent_nav_id])->orderBy('sort_index ASC')->asArray()->all() as $item) {
            --$startIndex;
            Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $startIndex], 'id=:id', ['id' => $item['id']])->execute();
        }
    }

    // create methods
    // @todo make static, moved to helper class?

    public function createDraft($title, $langId)
    {
        $_errors = [];

        // nav
        $nav = $this; // @todo use new self and make static method instead
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
     *
     * Create a new nav item with a specific language, title and alias based on a given nav item id.
     * All content of the source nav item will be copied dependent on the nav item type (page content, module link, redirect informations).
     *
     * @param $navItemId source nav item
     * @param $langId (new) target language
     * @param $title title of nav item
     * @param $alias alias of nav item
     * @return bool
     */
    public function createItemLanguageCopy($navItemId, $langId, $title, $alias)
    {
        $sourceNavItem = NavItem::findOne($navItemId);

        if (!$sourceNavItem) {
            return false;
        }

        if (NavItem::find()->where(['nav_id' => $sourceNavItem->nav_id, 'lang_id' => $langId])->one()) {
            return false;
        }

        $navItem = new NavItem();
        $navItem->attributes = $sourceNavItem->toArray();
        $navItem->title = $title;
        $navItem->alias = $alias;
        $navItem->lang_id = $langId;
        $navItem->setParentFromModel();

        if (!$navItem->save()) {
            return false;
        }

        // we have created the copy, but its seems like no version existis for the original to copy page,
        // so we can not copy any content, lets return true and skip copy process.
        if (empty($sourceNavItem->nav_item_type_id)) {
            return true;
        }
        
        return $sourceNavItem->copyTypeContent($navItem);
    }

    public function createPageFromDraft($parentNavId, $navContainerId, $langId, $title, $alias, $description, $fromDraftNavId, $isDraft = false)
    {
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

        if (!empty($errors)) {
            return $errors;
        }

        // get draft nav item data
        $draftNavItem = NavItem::findOne(['nav_id' => $fromDraftNavId]);

        $navItemPageId = $draftNavItem->type->id;
        $layoutId = $draftNavItem->type->layout_id;
        $pageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $navItemPageId]);

        // proceed save process
        $nav->save();
        $navItemPage = new NavItemPage();
        $navItemPage->layout_id = $layoutId;
        $navItemPage->timestamp_create = time();
        $navItemPage->version_alias = Module::VERSION_INIT_LABEL;
        $navItemPage->create_user_id = Module::getAuthorUserId();
        $navItemPage->nav_item_id = 0;
        
        if (!$navItemPage->validate()) {
            return $navItemPage->getErrors();
        }
        
        $navItemPage->save();
        
        foreach ($pageBlocks as $block) {
            $i = new NavItemPageBlockItem();
            $i->attributes = $block->toArray();
            $i->nav_item_page_id = $navItemPage->id;
            $i->insert();
        }

        $navItem->nav_id = $nav->id;
        $navItem->nav_item_type_id = $navItemPage->id;

        $navItem->save();
        
        $navItemPage->updateAttributes(['nav_item_id' => $navItem->id]);
        
        return true;
    }

    public function createPage($parentNavId, $navContainerId, $langId, $title, $alias, $layoutId, $description, $isDraft = false)
    {
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
        $navItemPage->attributes = ['nav_item_id' => 0, 'layout_id' => $layoutId, 'create_user_id' => Module::getAuthorUserId(), 'timestamp_create' => time(), 'version_alias' => Module::VERSION_INIT_LABEL];

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

        $navItemPage->updateAttributes(['nav_item_id' => $navItem->id]);
        
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
        $navItemPage->attributes = ['nav_item_id' => 0, 'layout_id' => $layoutId, 'create_user_id' => Module::getAuthorUserId(), 'timestamp_create' => time(), 'version_alias' => Module::VERSION_INIT_LABEL];

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

        $navItemPage->updateAttributes(['nav_item_id' => $navItem->id]);
        
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

    public function createRedirect($parentNavId, $navContainerId, $langId, $title, $alias, $redirectType, $redirectTypeValue, $description)
    {
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
