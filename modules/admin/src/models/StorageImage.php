<?php

namespace luya\admin\models;

use Yii;
use luya\admin\models\StorageFile;

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
    
    public function deleteSource()
    {
        $image = Yii::$app->storage->getImage($this->id);
        @unlink($image->serverSource);
    }
    
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleteSource();
            return true;
        } else {
            return false;
        }
    }
}
