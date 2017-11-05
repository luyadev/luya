<?php

namespace luya\cms\models;

use Yii;
use luya\admin\models\User;
use yii\helpers\Json;
use luya\cms\admin\Module;
use yii\base\InvalidParamException;

/**
 * Eventer-Logger for CMS Activitys
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_insertion
 * @property integer $is_update
 * @property integer $is_deletion
 * @property integer $timestamp
 * @property string $message
 * @property string $data_json
 * @property string $table_name
 * @property integer $row_id
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'onBeforeInsert']);
    }

    public function onBeforeInsert()
    {
        $this->timestamp = time();
        $this->user_id = (Yii::$app instanceof \luya\web\Application) ? Yii::$app->adminuser->getId() : 0;
        $this->data_json = json_encode($this->data_json);
    }
    
    public function getMessageArray()
    {
        try {
            return Json::decode($this->message);
        } catch (InvalidParamException $err) {
            return [];
        }
    }
    
    public function getRowDescriber()
    {
        if (!empty($this->row_id)) {
            switch ($this->table_name) {
                case "nav":
                    return Nav::findOne($this->row_id)->activeLanguageItem->title;
                case "nav_item":
                    return NavItem::findOne($this->row_id)->title;
                case "cms_nav_item_page_block_item":
                    $block = NavItemPageBlockItem::findOne($this->row_id);
                    if (!$block || $block->block == null) {
                        $arr = $this->getMessageArray();
                        if (!empty($arr) && isset($arr['blockName'])) {
                            return $arr['blockName'] . " ({$arr['pageTitle']})";
                        } else {
                            return;
                        }
                    }
                    return $block->block->getNameForLog() . " (" .$block->droppedPageTitle. ")";
            }
        }
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_log';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'is_insertion' => 'Is Insertion',
            'is_update' => 'Is Update',
            'is_deletion' => 'Is Deletion',
            'timestamp' => 'Timestamp',
            'message' => 'Message',
            'data_json' => 'Data Json',
            'table_name' => 'Table Name',
            'row_id' => 'Row ID',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_insertion', 'is_deletion', 'is_update', 'message', 'data_json', 'row_id', 'table_name'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'is_insertion',
            'is_update',
            'is_deletion',
            'timestamp',
            'action',
            'user',
        ];
    }
    
    public function getAction()
    {
        if ($this->is_insertion) {
            switch ($this->table_name) {
                case "nav_item":
                    return Module::t('log_action_insert_cms_nav_item', ['info' => $this->rowDescriber]);
                case "nav":
                    return Module::t('log_action_insert_cms_nav', ['info' => $this->rowDescriber]);
                case "cms_nav_item_page_block_item":
                    return Module::t('log_action_insert_cms_nav_item_page_block_item', ['info' => $this->rowDescriber]);
                default:
                    return Module::t('log_action_insert_unkown', ['info' => $this->rowDescriber]);
            }
        }
        
        if ($this->is_update) {
            switch ($this->table_name) {
                case "nav_item":
                    return Module::t('log_action_update_cms_nav_item', ['info' => $this->rowDescriber]);
                case "nav":
                    return Module::t('log_action_update_cms_nav', ['info' => $this->rowDescriber]);
                case "cms_nav_item_page_block_item":
                    return Module::t('log_action_update_cms_nav_item_page_block_item', ['info' => $this->rowDescriber]);
                default:
                    return Module::t('log_action_update_unkown', ['info' => $this->rowDescriber]);
            }
        }

        if ($this->is_deletion) {
            switch ($this->table_name) {
                case "nav_item":
                    return Module::t('log_action_delete_cms_nav_item', ['info' => $this->rowDescriber]);
                case "nav":
                    return Module::t('log_action_delete_cms_nav', ['info' => $this->rowDescriber]);
                case "cms_nav_item_page_block_item":
                    return Module::t('log_action_delete_cms_nav_item_page_block_item', ['info' => $this->rowDescriber]);
                default:
                    return Module::t('log_action_delete_unkown');
            }
        }
    }
    
    /**
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     *
     * @param integer $type Types of message:
     * + 1 = insertion
     * + 2 = update
     * + 3 = deletion
     * @param array $message
     * @param string $tableName
     * @param integer $rowId
     * @param array $additionalData
     * @return boolean
     */
    public static function add($type, array $message, $tableName, $rowId = 0, array $additionalData = [])
    {
        $model = new self();
        $model->setAttributes([
            'is_insertion' => ($type == 1) ? true : false,
            'is_update' => ($type == 2) ? true : false,
            'is_deletion' => ($type == 3) ? true : false,
            'table_name' => $tableName,
            'row_id' => $rowId,
            'message' => Json::encode($message),
            'data_json' => $additionalData,
        ]);
        return $model->insert(false);
    }
}
