<?php

namespace luya\admin\models;

use Yii;
use luya\admin\models\StorageFile;
use yii\db\ActiveRecord;

/**
 * StorageImage Model.
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class StorageImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_storage_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file_id'], 'required'],
            [['filter_id', 'resolution_width', 'resolution_height'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $this->deleteSource();
            return true;
        } else {
            return false;
        }
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
}
