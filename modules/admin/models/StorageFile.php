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
    
    public function delete()
    {
        $file = Yii::$app->storage->file->get($this->id);
        @unlink($file['source']);
        $this->is_deleted = 1;
        $this->update(false);
        return true;
    }
    
    /**
     * We can not global set is_deleted=0 to the where condition cause in some parts of the storage we want
     * to access the name_new_compound to rebuild old image paths
     * 
     * @return \yii\db\$this
     */
    public static function find()
    {
        return parent::find();
    } 
    
    public function onBeforeInsert()
    {
        $this->upload_timestamp = time();
        $this->upload_user_id = Yii::$app->adminuser->getId();
    }
}
