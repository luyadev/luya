<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;

/**
 * Create an Active Window where you can select Images and store them into a Ref Table.
 *
 * Usage example of registering Gallery Active Window:
 *
 * ```php
 * $config->aw->load([
 *     'class' => 'admin\aws\ImageCollectionActiveWindow',
 *     'refTableName' => 'gallery_album_image',
 *     'imageIdFieldName' => 'image_id',
 *     'refFieldName' => 'album_id',
 *     'alias' => 'Select Image',
 * ]);
 * ```
 *
 * The above example would required the following migration code for the ref table:
 *
 * ```php
 * $this->createTable("gallery_album_image", [
 *     "image_id" => "int(11) NOT NULL default 0",
 *     "album_id" => "int(11) NOT NULL default 0",
 * ]);
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ImageSelectCollectionActiveWindow extends ActiveWindow
{
    public $refTableName;

    public $imageIdFieldName;

    public $refFieldName;

    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = 'admin';

    /**
     * @var string The icon name from goolges material icon set (https://material.io/icons/)
     */
    public $icon = 'photo_library';

    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     *
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index');
    }

    public function callbackLoadAllImages()
    {
        $images = [];
        foreach ((new \yii\db\Query())->select(['image_id' => $this->imageIdFieldName])->where([$this->refFieldName => $this->getItemId()])->from($this->refTableName)->all() as $image) {
            $images[] = Yii::$app->storage->getImage($image['image_id'])->toArray();
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
        $imageId = Yii::$app->storage->addImage($fileId)->id;

        Yii::$app->db->createCommand()->insert($this->refTableName, [
            $this->imageIdFieldName => (int) $imageId,
            $this->refFieldName => (int) $this->getItemId(),
        ])->execute();

        return Yii::$app->storage->getImage($imageId)->toArray();
    }
}
