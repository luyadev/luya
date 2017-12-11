<?php

namespace luya\cms\models;

use Yii;
use luya\admin\models\Lang;
use yii\base\Exception;
use luya\cms\admin\Module;
use luya\admin\base\GenericSearchInterface;
use yii\db\ActiveRecordInterface;
use luya\admin\models\User;
use luya\helpers\Inflector;

/**
 * NavItem Model represents a Item bound to Nav and Language, each Nav(Menu) can contain a nav_item for each language.Each
 * cms_nav_item is related to a type of item (module, page or redirect) which is stored in nav_item_type (number) and another field
 * nav_item_type_id (pk of the table).
 *
 * @property \luya\cms\models\NavItemPage|\luya\cms\models\NavItemModule\luya\cms\models\NavItemRedirect $type The type object based on the current type id
 * @property integer $id
 * @property integer $nav_id
 * @property integer $lang_id
 * @property integer $nav_item_type
 * @property integer $nav_item_type_id
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $timestamp_create
 * @property integer $timestamp_update
 * @property string $title
 * @property string $alias
 * @property string $description
 * @property string $keywords
 * @property string $title_tag
 * @property \luya\cms\models\Nav $nav Nav Model.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NavItem extends \yii\db\ActiveRecord implements GenericSearchInterface
{
    const TYPE_PAGE = 1;

    const TYPE_MODULE = 2;

    const TYPE_REDIRECT = 3;

    public $parent_nav_id;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'validateAlias']);
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'eventBeforeUpdate']);
        
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventLogger']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'eventLogger']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'eventLogger']);
        
        $this->on(self::EVENT_AFTER_DELETE, function ($event) {
            $type = $event->sender->getType();
            if ($type) {
                $type->delete();
            }
            
            foreach (NavItemPage::find()->where(['nav_item_id' => $event->sender->id])->all() as $version) {
                $version->delete();
            }
        });
    }

    /**
     * Log the current event in a database to retrieve data in case of emergency. This method will be trigger
     * on: EVENT_BEFORE_DELETE, EVENT_AFTER_INSERT & EVENT_AFTER_UPDATE
     *
     * @param \yii\base\Event $event
     * @return boolean
     */
    protected function eventLogger($event)
    {
        switch ($event->name) {
            case 'afterInsert':
                return Log::add(1, ['tableName' => 'cms_nav_item', 'action' => 'insert', 'row' => $this->id], 'cms_nav_item', $this->id, $this->toArray());
            case 'afterUpdate':
                return Log::add(2, ['tableName' => 'cms_nav_item', 'action' => 'update', 'row' => $this->id], 'cms_nav_item', $this->id, $this->toArray());
            case 'afterDelete':
                return Log::add(3, ['tableName' => 'cms_nav_item', 'action' => 'delete', 'row' => $this->id], 'cms_nav_item', $this->id, $this->toArray());
        }
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_nav_item';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lang_id', 'title', 'alias', 'nav_item_type'], 'required'],
            [['nav_id', 'description', 'keywords', 'nav_item_type_id', 'title_tag'], 'safe'],
            [['timestamp_create'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Module::t('model_navitem_title_label'),
            'alias' => Module::t('model_navitem_alias_label'),
            'title_tag' => Module::t('model_navitem_title_tag_label'),
        ];
    }

    public function getUpdateUser()
    {
        return $this->hasOne(User::class, ['id' => 'update_user_id']);
    }
    
    public function slugifyAlias()
    {
        $this->alias = Inflector::slug($this->alias, '-', true, false);
    }
    
    private $_type;
    
    /**
     * GET the type object based on the nav_item_type defintion and the nav_item_type_id which is the
     * primary key for the corresponding type table (page, module, redirect). This approach has been choosen
     * do dynamically extend type of pages whithout any limitation.
     *
     * @return \luya\cms\models\NavItemPage|\luya\cms\models\NavItemModule|\luya\cms\models\NavItemRedirect Returns the object based on the type
     * @throws Exception
     */
    public function getType()
    {
        if ($this->_type === null) {
            
            // what kind of item type are we looking for
            if ($this->nav_item_type == self::TYPE_PAGE) {
                $this->_type = NavItemPage::findOne($this->nav_item_type_id);
            } elseif ($this->nav_item_type == self::TYPE_MODULE) {
                $this->_type = NavItemModule::findOne($this->nav_item_type_id);
            } elseif ($this->nav_item_type == self::TYPE_REDIRECT) {
                $this->_type = NavItemRedirect::findOne($this->nav_item_type_id);
            }
            
            if ($this->_type === null) {
                $this->_type = false;
            }
            
            // set context for the object
            /// 5.4.2016: Discontinue, as the type model does have getNavItem relation
            //$this->_type->setNavItem($this);
        }
        
        return $this->_type;
    }

    /**
     * Get the related nav entry for this nav_item.
     *
     * @return ActiveQuery
     */
    public function getNav()
    {
        return $this->hasOne(Nav::className(), ['id' => 'nav_id']);
    }

    /**
     * Get the render content for the specific type, see the defintion of `getContent()` in the available types.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->getType()->getContent();
    }

    /**
     * Update attributes of the current nav item type relation.
     *
     * @param array $postData
     * @return boolean Whether the update has been successfull or not
     */
    public function updateType(array $postData)
    {
        $model = $this->getType();
        $model->setAttributes($postData);
        return $model->update();
    }

    /**
     * Get the parent nav id information from the existing getNav relation and overrides the public properties parent_nav_id of this model.
     * This is applied because of the validation process to make sure this rewrite does not already exists.
     */
    public function setParentFromModel()
    {
        $this->parent_nav_id = $this->nav->parent_nav_id;
    }

    public function verifyAlias($alias, $langId)
    {
        if (Yii::$app->hasModule($alias) && $this->parent_nav_id == 0) {
            $this->addError('alias', Module::t('nav_item_model_error_modulenameexists', ['alias' => $alias]));

            return false;
        }

        if ($this->parent_nav_id === null) {
            $this->addError('parent_nav_id', Module::t('nav_item_model_error_parentnavidcannotnull'));
        }

        if ($this->find()->where(['alias' => $alias, 'lang_id' => $langId])->leftJoin('cms_nav', 'cms_nav_item.nav_id=cms_nav.id')->andWhere(['=', 'cms_nav.parent_nav_id', $this->parent_nav_id])->one()) {
            $this->addError('alias', Module::t('nav_item_model_error_urlsegementexistsalready'));

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
        $this->create_user_id = Module::getAuthorUserId();
        $this->update_user_id = Module::getAuthorUserId();
        $this->slugifyAlias();
    }
    
    public function eventBeforeUpdate()
    {
        $this->timestamp_update = time();
        $this->update_user_id = Module::getAuthorUserId();
        $this->slugifyAlias();
    }

    public function updateTimestamp()
    {
        $this->updateAttributes([
            'timestamp_update' => time(),
            'update_user_id' => Module::getAuthorUserId(),
        ]);
    }

    /**
     * temp disabled the links for the specific module, cause we are not yet able to handle module integration blocks (find the module inside the content), so wo just
     * display all nav items tempo.
     *
     *
     * @param unknown $moduleName
     * @return array|\yii\db\ActiveRecord[]
     * @deprecated remove in 1.0.1
     */
    public static function fromModule($moduleName)
    {
        return self::find()->all();
        //return self::find()->leftJoin('cms_nav_item_module', 'nav_item_type_id=cms_nav_item_module.id')->where(['nav_item_type' => 2, 'cms_nav_item_module.module_name' => $moduleName])->all();
    }

    /* GenericSearchInterface */

    /**
     * @inheritdoc
     */
    public function genericSearchFields()
    {
        return ['title', 'container'];
    }
    
    /**
     * @inheritdoc
     */
    public function genericSearchHiddenFields()
    {
        return ['nav_id'];
    }

    /**
     * @inheritdoc
     */
    public function genericSearch($searchQuery)
    {
        $data = [];
        
        foreach (self::find()->select(['nav_id', 'title'])->orWhere(['like', 'title', $searchQuery])->with('nav')->distinct()->each() as $item) {
            if ($item->nav) {
                $data[] = [
                    'title' => $item->title,
                    'nav_id' => $item->nav_id,
                    'container' => $item->nav->navContainer->name,
                ];
            }
        }
        
        return $data;
    }
    
    /**
     * Return the angular state provider config for custom.cmsedit to handle the selection
     * and jump/linking in the search results container.
     *
     * {@inheritDoc}
     *
     * @see \admin\base\GenericSearchInterface::genericSearchStateProvider()
     */
    public function genericSearchStateProvider()
    {
        return [
            'state' => 'custom.cmsedit',
            'params' => [
                'navId' => 'nav_id',
            ],
        ];
    }
    
    public function getLang()
    {
        return $this->hasOne(Lang::className(), ['id' => 'lang_id']);
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
        $pageItem->nav_item_id = $targetNavItem->id;

        if (!$pageItem->save()) {
            return false;
        }

        $targetNavItem->nav_item_type_id = $pageItem->id;
        if (!$targetNavItem->save()) {
            return false;
        }

        $pageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $sourcePageItem->id]);

        $idLink = [];
        foreach ($pageBlocks as $block) {
            $blockItem = new NavItemPageBlockItem();
            $blockItem->attributes = $block->toArray();
            $blockItem->nav_item_page_id = $pageItem->id;
            $blockItem->insert();
            $idLink[$block->id] = $blockItem->id;
        }
        // check if prev_id is used, check if id is in set - get new id and set new prev_ids in copied items
        $newPageBlocks = NavItemPageBlockItem::findAll(['nav_item_page_id' => $pageItem->id]);
        foreach ($newPageBlocks as $block) {
            if ($block->prev_id) {
                if (isset($idLink[$block->prev_id])) {
                    $block->prev_id = $idLink[$block->prev_id];
                }
            }
            $block->update(false);
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
    public function copyTypeContent(ActiveRecordInterface $targetNavItem)
    {
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
