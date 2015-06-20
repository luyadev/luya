<?php

namespace admin\models;

class StorageFile extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_storage_file';
    }

    public function rules()
    {
        return [
            [['name_original', 'name_new', 'mime_type', 'name_new_compound', 'extension', 'hash_file', 'hash_name'], 'required'],
            [['folder_id'], 'safe'],
        ];
    }
}
