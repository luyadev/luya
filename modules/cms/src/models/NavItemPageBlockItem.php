<?php

namespace luya\cms\models;

use Yii;
use luya\cms\admin\Module;
use luya\traits\CacheableTrait;
use luya\helpers\ArrayHelper;
use yii\db\ActiveQuery;
use yii\helpers\Json;

/**
 * Represents an ITEM for the type NavItemPage.
 *
 * Sort_index numbers always starts from 0 and not from 1, like a default array behaviour. If a
 * negative sort_index is provided its always the last sort_index item (reason: we dont know the sort key of
 * the "at the end" dropparea).
 *
 * @property integer $id
 * @property integer $block_id
 * @property string $placeholder_var
 * @property integer $nav_item_page_id
 * @property integer $prev_id
 * @property string $json_config_values
 * @property string $json_config_cfg_values
 * @property integer $is_dirty
 * @property integer $create_user_id
 * @property integer $update_user_id
 * @property integer $timestamp_create
 * @property integer $timestamp_update
 * @property integer $sort_index
 * @property integer $is_hidden
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NavItemPageBlockItem extends \yii\db\ActiveRecord
{
    private $_olds = [];

    use CacheableTrait;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_nav_item_page_block_item';
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'eventAfterInsert']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'eventAfterUpdate']);
        $this->on(self::EVENT_AFTER_DELETE, [$this, 'eventAfterDelete']);
        $this->on(self::EVENT_AFTER_VALIDATE, [$this, 'ensureInputValues']);
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['json_config_values', 'json_config_cfg_values'], function ($attribute, $params) {
                // if its not an array, the attribute is not dirty and has not to be serialized from input.
                if (is_array($this->$attribute)) {
                    $data = ArrayHelper::typeCast($this->$attribute);
                    foreach ($data as $key => $value) {
                        if ($value === null) {
                            unset($data[$key]);
                        }
                    }
                
                    if (isset($data['__e']) && count($data) >= 2) {
                        unset($data['__e']);
                    }
                
                    if (empty($data)) {
                        $data['__e'] = '__v';
                    }
                
                    $this->$attribute = Json::encode($data, JSON_FORCE_OBJECT);
                }
            }, 'skipOnEmpty' => false],
            [['block_id', 'nav_item_page_id', 'prev_id', 'create_user_id', 'update_user_id', 'timestamp_create', 'timestamp_update', 'sort_index'], 'integer'],
            [['is_dirty', 'is_hidden'], 'boolean'],
            [['placeholder_var'], 'required'],
            [['json_config_values', 'json_config_cfg_values'], 'string'],
            [['placeholder_var'], 'string', 'max' => 80],
            [['variation'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scene = parent::scenarios();
        $scene['restcreate'] = $scene['default'];
        $scene['restupdate'] = $scene['default'];
        return $scene;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'block_id' => 'Block ID',
            'placeholder_var' => 'Placeholder Var',
            'nav_item_page_id' => 'Nav Item Page ID',
            'prev_id' => 'Prev ID',
            'json_config_values' => 'Json Config Values',
            'json_config_cfg_values' => 'Json Config Cfg Values',
            'is_dirty' => 'Is Dirty',
            'create_user_id' => 'Create User ID',
            'update_user_id' => 'Update User ID',
            'timestamp_create' => 'Timestamp Create',
            'timestamp_update' => 'Timestamp Update',
            'sort_index' => 'Sort Index',
            'is_hidden' => 'Is Hidden',
            'variation' => 'Variation',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields['objectdetail'] = function ($model) {
            return NavItemPage::getBlock($model->id);
        };
        return $fields;
    }
    
    protected function ensureInputValues($event)
    {
        // sort index fixture

        if (!$this->isNewRecord) {
            $this->_olds = $this->getOldAttributes();
        }
        // its a negative value, so its a last item, lets find the last index for current config
        if ($this->sort_index < 0) {
            $last = self::originalFind()->andWhere(['nav_item_page_id' => $this->nav_item_page_id, 'placeholder_var' => $this->placeholder_var, 'prev_id' => $this->prev_id])->orderBy(['sort_index' => SORT_DESC])->one();
            if (!$last) {
                $this->sort_index = 0;
            } else {
                $this->sort_index = $last->sort_index + 1;
            }
        } else { // its not a negative value, we have to find the positions after the current sort index and update to a higher level
            $higher = self::originalFind()->where(['>=', 'sort_index', $this->sort_index])->andWhere(['nav_item_page_id' => $this->nav_item_page_id, 'placeholder_var' => $this->placeholder_var, 'prev_id' => $this->prev_id])->all();
            foreach ($higher as $item) {
                $newSortIndex = $item->sort_index + 1;
                Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $newSortIndex], ['id' => $item->id])->execute();
            }
        }
        
        // manipulate timestamps
        if ($this->isNewRecord) {
            $this->timestamp_create = time();
            $this->timestamp_update = time();
            $this->create_user_id = Module::getAuthorUserId();
        } else {
            $this->deleteHasCache(['blockcache', (int) $this->id]);
            $this->is_dirty = true;
            $this->update_user_id = Module::getAuthorUserId();
            $this->timestamp_update = time();
        }
    }

    public function eventAfterUpdate()
    {
        $this->updateNavItemTimesamp();
        if (!empty($this->_olds)) {
            $oldPlaceholderVar = $this->_olds['placeholder_var'];
            $oldPrevId = (int) $this->_olds['prev_id'];
            if ($oldPlaceholderVar != $this->placeholder_var || $oldPrevId != $this->prev_id) {
                $this->reindex($this->nav_item_page_id, $oldPlaceholderVar, $oldPrevId);
            }
            $this->reindex($this->nav_item_page_id, $this->placeholder_var, $this->prev_id);
            Log::add(2, ['tableName' => 'cms_nav_item_page_block_item', 'action' => 'update', 'row' => $this->id, 'pageTitle' => $this->droppedPageTitle, 'blockName' => $this->block->getNameForLog()], 'cms_nav_item_page_block_item', $this->id);
        }
    }

    public function eventBeforeDelete()
    {
        // delete all attached sub blocks
        $this->deleteAllSubBlocks($this->id);
        //save block data for afterDeleteEvent
        $this->_olds = $this->getOldAttributes();
        // verify if the block exists or not
        $class = ($this->block) ? $this->block->getNameForLog() : '[class has been removed from the filesystem]';
        // log event
        Log::add(3, ['tableName' => 'cms_nav_item_page_block_item', 'action' => 'delete', 'row' => $this->id, 'pageTitle' => $this->droppedPageTitle, 'blockName' => $class], 'cms_nav_item_page_block_item', $this->id);
    }

    public function eventAfterDelete()
    {
        $this->updateNavItemTimesamp();
        if (!empty($this->_olds)) {
            $this->reindex($this->_olds['nav_item_page_id'], $this->_olds['placeholder_var'], $this->_olds['prev_id']);
        }
    }

    public function eventAfterInsert()
    {
        $this->updateNavItemTimesamp();
        $this->reindex($this->nav_item_page_id, $this->placeholder_var, $this->prev_id);
        Log::add(1, ['tableName' => 'cms_nav_item_page_block_item', 'action' => 'insert', 'row' => $this->id, 'pageTitle' => $this->droppedPageTitle, 'blockName' => $this->block->getNameForLog()], 'cms_nav_item_page_block_item', $this->id);
    }

    private function deleteAllSubBlocks($blockId)
    {
        if ($blockId) {
            $subBlocks = NavItemPageBlockItem::findAll(['prev_id' => $blockId]);
            foreach ($subBlocks as $block) {
                // check for attached sub blocks and start recursion
                $attachedBlocks = NavItemPageBlockItem::findAll(['prev_id' => $block->id]);
                if ($attachedBlocks) {
                    $this->deleteAllSubBlocks($block->id);
                }
                $block->delete();
            }
        }
    }

    /**
     * Reindex the page block items in order to get requestd sorting.
     *
     * @param unknown $navItemPageId
     * @param unknown $placeholderVar
     * @param unknown $prevId
     */
    private function reindex($navItemPageId, $placeholderVar, $prevId)
    {
        $index = 0;
        $datas = self::originalFind()->andWhere(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])->orderBy(['sort_index' => SORT_ASC, 'timestamp_create' => SORT_DESC])->all();
        foreach ($datas as $item) {
            Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $index], ['id' => $item->id])->execute();
            ++$index;
        }
    }
    
    private function updateNavItemTimesamp()
    {
        // if state makes sure this does not happend when the nav item page is getting deleted and triggers the child delete process.
        if ($this->navItemPage) {
            if ($this->navItemPage->forceNavItem) {
                $this->navItemPage->forceNavItem->updateTimestamp();
            }
        }
    }

    public function getDroppedPageTitle()
    {
        // if state makes sure this does not happend when the nav item page is getting deleted and triggers the child delete process.
        if ($this->navItemPage) {
            if ($this->navItemPage->forceNavItem) {
                return $this->navItemPage->forceNavItem->title;
            }
        }

        return;
    }
    
    public static function originalFind()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }
    
    /**
     * Default sort on find command.
     *
     * @return ActiveQuery
     */
    public static function find()
    {
        return parent::find()->orderBy(['sort_index' => SORT_ASC]);
    }
    
    /**
     * Get the block for the page block item
     *
     * @return ActiveQuery
     */
    public function getBlock()
    {
        return $this->hasOne(Block::className(), ['id' => 'block_id']);
    }
    
    /**
     * Get the corresponding page where the block is stored.
     *
     * @return ActiveQuery
     */
    public function getNavItemPage()
    {
        return $this->hasOne(NavItemPage::className(), ['id' => 'nav_item_page_id']);
    }
}
