<?php

namespace admin\models;

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
            [['filter_id'], 'safe'],
        ];
    }

    public function getFile()
    {
        return $this->hasOne(\admin\models\StorageFile::className(), ['id' => 'file_id']);
    }
}
