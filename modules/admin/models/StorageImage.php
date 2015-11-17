<?php

namespace admin\models;
use admin\models\StorageFile;

class StorageImage extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_storage_image';
    }

    public function rules()
    {
        return [
            [['file_id'], 'required'],
            [['filter_id', 'resolution_width', 'resolution_height'], 'safe'],
        ];
    }

    public function getFile()
    {
        return $this->hasOne(StorageFile::className(), ['id' => 'file_id']);
    }
}
