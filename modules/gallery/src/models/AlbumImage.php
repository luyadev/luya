<?php

namespace luya\gallery\models;

use Yii;

/**
 * This is the model class for table "gallery_album_image".
 *
 * @property integer $image_id
 * @property integer $album_id
 */
class AlbumImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_album_image';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image_id', 'album_id'], 'required'],
            [['image_id', 'album_id'], 'integer'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image_id' => 'Image ID',
            'album_id' => 'Album ID',
        ];
    }
    
    /**
     * Return image object if exists.
     *
     * @return \luya\admin\image\Item|boolean
     */
    public function getImage()
    {
        return Yii::$app->storage->getImage($this->image_id);
    }
}
