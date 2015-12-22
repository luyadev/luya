<?php

namespace cmsadmin\models;

use Yii;
use admin\models\Lang;
use yii\base\Exception;

/**
 * Each creation of a navigation block requires the nav_item_type_id which need to be created first with NavItemType Model.
 *
 * @author nadar
 */
class NavItem extends \yii\db\ActiveRecord implements \admin\base\GenericSearchInterface
{
    const TYPE_PAGE = 1;

    const TYPE_MODULE = 2;

    const TYPE_REDIRECT = 3;

    public $parent_nav_id = null;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'validateAlias']);
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'eventBeforeUpdate']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'logEvent']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'logEvent']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'logEvent']);
    }

    public function logEvent($e)
    {
        switch ($e->name) {
            case 'afterInsert':
                Log::add(1, "nav_item.insert '".$this->title."', cms_nav_item.id '".$this->id."'", $this->toArray());
                break;
            case 'afterUpdate':
                Log::add(2, "nav_item.update '".$this->title."', cms_nav_item.id '".$this->id."'", $this->toArray());
                break;
            case 'afterDelete':
                Log::add(3, "nav_item.delete '".$this->title."', cms_nav_item.id '".$this->id."'", $this->toArray());
                break;
        }
    }

    public static function tableName()
    {
        return 'cms_nav_item';
    }

    public function rules()
    {
        return [
            [['lang_id', 'title', 'alias', 'nav_item_type'], 'required'],
            [['nav_id', 'description'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => \cmsadmin\Module::t('model_navitem_title_label'),
            'alias' => \cmsadmin\Module::t('model_navitem_alias_label'),
        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['title', 'alias', 'nav_item_type', 'nav_id', 'lang_id', 'description'],
        ];
    }

    public function getType()
    {
        switch ($this->nav_item_type) {
            case self::TYPE_PAGE:
                $object = NavItemPage::findOne($this->nav_item_type_id);
                break;
            case self::TYPE_MODULE:
                $object = NavItemModule::findOne($this->nav_item_type_id);
                break;
            case self::TYPE_REDIRECT:
                $object = NavItemRedirect::findOne($this->nav_item_type_id);
                break;
        }
        // assign the current context for an item type object.
        $object->setNavItem($this);

        return $object;
    }

    public function getNav()
    {
        return Nav::find()->where(['id' => $this->nav_id])->one();
    }

    public function getContent()
    {
        return $this->getType()->getContent();
    }

    public function updateType($postData)
    {
        $model = $this->getType();
        $model->attributes = $postData;

        return $model->update();
    }

    public function setParentFromModel()
    {
        $this->parent_nav_id = $this->nav->parent_nav_id;
    }

    public function verifyAlias($alias, $langId)
    {
        if (Yii::$app->hasModule($alias) && $this->parent_nav_id == 0) {
            $this->addError('alias', 'Die URL darf nicht verwendet werden da es ein Modul mit dem gleichen Namen gibt.');

            return false;
        }

        if ($this->parent_nav_id === null) {
            $this->addError('parent_nav_id', 'parent_nav_id can not be null to verify the alias validation process.');
        }

        if ($this->find()->where(['alias' => $alias, 'lang_id' => $langId])->leftJoin('cms_nav', 'cms_nav_item.nav_id=cms_nav.id')->andWhere(['=', 'cms_nav.parent_nav_id', $this->parent_nav_id])->one()) {
            $this->addError('alias', 'Diese URL existiert bereits und ist deshalb ungültig.');

            return false;
        }
    }

    public function validateAlias()
    {
        $dirty = $this->getDirtyAttributes(['alias']);
        if (!isset($dirty['alias'])) {
            return true;
        }

        if (!$this->verifyAlias($this->alias, $this->lang_id)) {
            return false;
        }
    }

    public function beforeCreate()
    {
        $this->timestamp_create = time();
        $this->timestamp_update = 0;
        $this->create_user_id = Yii::$app->adminuser->getId();
        $this->update_user_id = Yii::$app->adminuser->getId();
    }
    
    public function eventBeforeUpdate()
    {
        $this->timestamp_update = time();
        $this->update_user_id = Yii::$app->adminuser->getId();
    }

    /**
     * temp disabled the links for the specific module, cause we are not yet able to handle module integration blocks (find the module inside the content), so wo just
     * display all nav items tempo.
     * 
     * @todo fix me above!
     *
     * @param unknown $moduleName
     */
    public static function fromModule($moduleName)
    {
        return self::find()->all();
        //return self::find()->leftJoin('cms_nav_item_module', 'nav_item_type_id=cms_nav_item_module.id')->where(['nav_item_type' => 2, 'cms_nav_item_module.module_name' => $moduleName])->all();
    }

    /* GenericSearchInterface */

    public function genericSearchFields()
    {
        return ['title', 'alias'];
    }

    public function genericSearch($searchQuery)
    {
        $query = self::find();
        $fields = $this->genericSearchFields();
        foreach ($fields as $field) {
            $query->orWhere(['like', $field, $searchQuery]);
        }

        return $query->select($fields)->asArray()->all();
    }

    /**
     * @todo use AR or queryCommand? NavItem::find()->leftJoin('cms_nav_item_module', 'nav_item_type_id=cms_nav_item_module.id')->where(['nav_item_type' => 2, 'cms_nav_item_module.module_name' => $moduleName])->asArray()->one()
     *
     * @param unknown $moduleName
     *
     * @return unknown
     */
    public static function findNavItem($moduleName)
    {
        // current active lang:
        $default = Lang::findActive();

        $query = Yii::$app->db->createCommand('SELECT i.* FROM cms_nav_item as i LEFT JOIN (cms_nav_item_module as m) ON (i.nav_item_type_id=m.id) WHERE i.nav_item_type=2 AND i.lang_id=:lang_id AND m.module_name=:module')->bindValues([
            ':module' => $moduleName, ':lang_id' => $default['id'],
        ])->queryOne();

        return $query;
    }

    public function getLang()
    {
        return $this->hasOne(\admin\models\Lang::className(), ['id' => 'lang_id']);
    }

    /**
     *
     * Copy content of type cms_nav_item_page to a target nav item. This will create a new entry in cms_nav_item_page and for every used block a new entry in cms_nav_item_page_block_item
     *
     * @param $targetNavItem nav item object
     * @return bool
     */
    public function copyPageItem($targetNavItem)
    {
        if ($this->nav_item_type !== 1) {
            return false;
        }

        $sourcePageItem = NavItemPage::findOne($this->nav_item_type_id);

        if (!$sourcePageItem) {
            return false;
        }
        $pageItem = new NavItemPage();
        $pageItem->attributes = $sourcePageItem->toArray();

        if (!$pageItem->save()) {
            return false;
        }

        $targetNavItem->nav_item_type_id = $pageItem->id;
        if (!$targetNavItem->save()) {
            return false;
        }

        $pageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $sourcePageItem->id]);

        foreach ($pageBlocks as $block) {
            $blockItem = new NavItemPageBlockItem();
            $blockItem->attributes = $block->toArray();
            $blockItem->nav_item_page_id = $pageItem->id;
            $blockItem->insert();
        }
        return true;
    }

    /**
     *
     * Copy content of type cms_nav_item_module to a target nav item. This will create a new entry in cms_nav_item_module.
     *
     * @param $targetNavItem
     * @return bool
     */
    public function copyModuleItem($targetNavItem)
    {
        if ($this->nav_item_type !== 2) {
            return false;
        }

        $sourceModuleItem = NavItemModule::findOne($this->nav_item_type_id);
        if (!$sourceModuleItem) {
            return false;
        }
        $moduleItem = new NavItemModule();
        $moduleItem->attributes = $sourceModuleItem->toArray();

        if (!$moduleItem->save()) {
            return false;
        }

        $targetNavItem->nav_item_type_id = $moduleItem->id;
        return $targetNavItem->save();
    }

    /**
     *
     * Copy content of type cms_nav_item_redirect to a target nav item. This will create a new entry in cms_nav_item_redirect.
     *
     * @param $targetNavItem
     * @return bool
     */
    public function copyRedirectItem($targetNavItem)
    {
        if ($this->nav_item_type !== 3) {
            return false;
        }

        $sourceRedirectItem = NavItemRedirect::findOne($this->nav_item_type_id);
        if (!$sourceRedirectItem) {
            return false;
        }
        $redirectItem = new NavItemRedirect();
        $redirectItem->attributes = $sourceRedirectItem->toArray();

        if (!$redirectItem->save()) {
            return false;
        }

        $targetNavItem->nav_item_type_id = $redirectItem->id;
        return $targetNavItem->save();
    }

    /**
     *
     * Copy nav item type content.
     *
     * @param $targetNavItem
     * @return bool
     * @throws Exception type not recognized (1,2,3)
     */
    public function copyTypeContent($targetNavItem)
    {
        if (!$targetNavItem instanceof \yii\db\ActiveRecord) {
            throw new Exception("Target nav item must be an instance of ActiveRecord.");
        }
        switch ($this->nav_item_type) {
            case 1:
                return $this->copyPageItem($targetNavItem);
            case 2:
                return $this->copyModuleItem($targetNavItem);
            case 3:
                return $this->copyRedirectItem($targetNavItem);
        }

        throw new Exception("Unable to find nav item type.");
    }
}
