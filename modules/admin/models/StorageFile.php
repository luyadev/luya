<?php

namespace admin\models;

use Yii;

class StorageFile extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'onBeforeInsert']);
    }
    
    public static function tableName()
    {
        return 'admin_storage_file';
    }

    
    public function rules()
    {
        return [
            [['name_original', 'name_new', 'mime_type', 'name_new_compound', 'extension', 'hash_file', 'hash_name'], 'required'],
            [['folder_id', 'upload_timestamp', 'file_size', 'upload_user_id', 'upload_timestamp'], 'safe'],
        ];
    }
    
    public function onBeforeInsert()
    {
        $this->upload_timestamp = time();
        $this->upload_user_id = Yii::$app->adminuser->getId();
    }
}
