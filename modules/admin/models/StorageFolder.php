<?php

namespace admin\models;

class StorageFolder extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_storage_folder';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['parent_id', 'timestamp_create', 'is_deleted'], 'safe'],
        ];
    }
}
