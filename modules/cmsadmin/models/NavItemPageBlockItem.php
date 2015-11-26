<?php

namespace cmsadmin\models;

use Yii;

/**
 * sort_index numbers always starts from 0 and not from 1, like a default array behaviour. If a
 * negative sort_index is provided its always the last sort_index item (reason: we dont know the sort key of
 * the "at the end" dropparea).
 *
 * @todo remove scenarios?
 *
 * @author nadar
 */
class NavItemPageBlockItem extends \yii\db\ActiveRecord
{
    private $_olds = [];

    public static function tableName()
    {
        return 'cms_nav_item_page_block_item';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeInsert']);
        $this->on(self::EVENT_AFTER_INSERT, [$this, 'eventAfterInsert']);
        $this->on(self::EVENT_AFTER_UPDATE, [$this, 'eventAfterUpdate']);
        $this->on(self::EVENT_BEFORE_UPDATE, [$this, 'eventBeforeUpdate']);
        $this->on(self::EVENT_BEFORE_DELETE, [$this, 'eventBeforeDelete']);
    }

    public function rules()
    {
        return [
            [['sort_index'], 'resortIndex', 'on' => ['restcreate']],
            [['sort_index'], 'resortIndex', 'on' => ['restupdate']],
        ];
    }

    /**
     * resort the sort_index numbers for all items on the same: naav_item_page_id and prev_id and placholder_var.
     */
    public function resortIndex()
    {
        if (!$this->isNewRecord) {
            $this->_olds = $this->getOldAttributes();
        }
        // its a negative value, so its a last item, lets find the last index for current config
        if ($this->sort_index < 0) {
            $last = self::find()->andWhere(['nav_item_page_id' => $this->nav_item_page_id, 'placeholder_var' => $this->placeholder_var, 'prev_id' => $this->prev_id])->orderBy('sort_index DESC')->one();
            if (!$last) {
                $this->sort_index = 0;
            } else {
                $this->sort_index = $last->sort_index + 1;
            }
        } else { // its not a negative value, we have to find the positions after the current sort index and update to a higher level
            $higher = self::find()->where('sort_index >= :index', ['index' => $this->sort_index])->andWhere(['nav_item_page_id' => $this->nav_item_page_id, 'placeholder_var' => $this->placeholder_var, 'prev_id' => $this->prev_id])->all();

            foreach ($higher as $item) {
                $newSortIndex = $item->sort_index + 1;
                Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $newSortIndex], ['id' => $item->id])->execute();
            }
        }
    }

    public function eventBeforeUpdate()
    {
        $this->is_dirty = 1;
        $this->update_user_id = Yii::$app->adminuser->getId();
        $this->timestamp_update = time();
    }

    public function eventAfterUpdate()
    {
        $oldPlaceholderVar = $this->_olds['placeholder_var'];
        $oldPrevId = (int) $this->_olds['prev_id'];
        if ($oldPlaceholderVar != $this->placeholder_var || $oldPrevId != $this->prev_id) {
            $this->reindex($this->nav_item_page_id, $oldPlaceholderVar, $oldPrevId);
        }
        $this->reindex($this->nav_item_page_id, $this->placeholder_var, $this->prev_id);
        Log::add(2, "block.update '".$this->block->class."', cms_nav_item_page_block_item.id '".$this->id."'");
    }

    public function eventBeforeDelete()
    {
        Log::add(3, "block.delete '".$this->block->class."', cms_nav_item_page_block_item.id '".$this->id."'");
    }

    public function eventAfterInsert()
    {
        $this->reindex($this->nav_item_page_id, $this->placeholder_var, $this->prev_id);
        Log::add(1, "block.insert '".$this->block->class."', cms_nav_item_page_block_item.id '".$this->id."'");
    }

    public function eventBeforeInsert()
    {
        $this->timestamp_create = time();
        $this->create_user_id = Yii::$app->adminuser->getId();
        if (empty($this->json_config_cfg_values)) {
            $this->json_config_cfg_values = json_encode([], JSON_FORCE_OBJECT);
        }

        if (empty($this->json_config_values)) {
            $this->json_config_values = json_encode([], JSON_FORCE_OBJECT);
        }
    }

    private function reindex($navItemPageId, $placeholderVar, $prevId)
    {
        $index = 0;
        $datas = self::find()->andWhere(['nav_item_page_id' => $navItemPageId, 'placeholder_var' => $placeholderVar, 'prev_id' => $prevId])->orderBy('sort_index ASC')->all();
        foreach ($datas as $item) {
            Yii::$app->db->createCommand()->update(self::tableName(), ['sort_index' => $index], ['id' => $item->id])->execute();
            ++$index;
        }
    }

    public static function find()
    {
        return parent::find()->orderBy('sort_index ASC');
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['block_id', 'placeholder_var', 'nav_item_page_id', 'json_config_values', 'json_config_cfg_values', 'prev_id', 'sort_index'],
            'restupdate' => ['block_id', 'placeholder_var', 'nav_item_page_id', 'json_config_values', 'json_config_cfg_values', 'prev_id', 'sort_index'],
            'default' => ['block_id', 'placeholder_var', 'nav_item_page_id', 'json_config_values', 'json_config_cfg_values', 'prev_id', 'sort_index'],
        ];
    }

    public function getBlock()
    {
        return $this->hasOne(\cmsadmin\models\Block::className(), ['id' => 'block_id']);
    }
}
