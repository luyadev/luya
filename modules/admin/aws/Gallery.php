<?php

namespace admin\aws;

use Yii;

/**
 * based on the example table.
 *
 * $this->createTable("gallery_album_image", [
 *     "image_id" => "int(11) NOT NULL default 0",
 *     "album_id" => "int(11) NOT NULL default 0",
 * ]);
 *
 * @param string $refTableName     gallery_album_image
 * @param string $imageIdFieldName image_id
 * @param string $refFieldName     album_id
 */
class Gallery extends \admin\ngrest\base\ActiveWindow
{
    public $refTableName = null;

    public $imageIdFieldName = null;

    public $refFieldName = null;

    public $module = 'admin';

    /*
    public function __construct($refTableName, $imageIdFieldName, $refFieldName)
    {
        $this->refTableName = $refTableName;
        $this->imageIdFieldName = $imageIdFieldName;
        $this->refFieldName = $refFieldName;
    }
    */

    public function index()
    {
        return $this->render('index');
    }

    public function callbackLoadAllImages()
    {
        $images = [];
        foreach ((new \yii\db\Query())->select(['image_id' => $this->imageIdFieldName])->where([$this->refFieldName => $this->getItemId()])->from($this->refTableName)->all() as $image) {
            $images[] = Yii::$app->storage->getImage($image['image_id']);
        }

        return $images;
    }

    public function callbackRemoveFromIndex($imageId)
    {
        return Yii::$app->db->createCommand()->delete($this->refTableName, [
            $this->imageIdFieldName => (int) $imageId,
            $this->refFieldName => (int) $this->getItemId(),
        ])->execute();
    }

    public function callbackAddImageToIndex($fileId)
    {
        $imageId = Yii::$app->storage->addImage($fileId);

        Yii::$app->db->createCommand()->insert($this->refTableName, [
            $this->imageIdFieldName => (int) $imageId,
            $this->refFieldName => (int) $this->getItemId(),
        ])->execute();

        return $imageId;
    }
}
