<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;
use yii\base\InvalidConfigException;
use yii\db\Query;

/**
 * Create an Active Window where you can select Images and store them into a Ref Table.
 *
 * Usage example of registering Gallery Active Window:
 *
 * ```php
 * public function ngRestActiveWindows()
 * {
 *     return [
 *         ['class' => 'admin\aws\ImageCollectionActiveWindow',
 *          'refTableName' => 'gallery_album_image',
 *          'imageIdFieldName' => 'image_id',
 *          'refFieldName' => 'album_id',
 *          'alias' => 'Select Image',
 *         ],
 *     ];
 * }
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
 * @since 1.0.0
 */
class ImageSelectCollectionActiveWindow extends ActiveWindow
{
    /**
     * @var string The table which should be used in order to store the reference entry.
     */
    public $refTableName;

    /**
     * @var string The fieldname inside the {{luya\admin\aws\ImageSelectCollectionActiveWindow::$refTableName}} to store the image id.
     */
    public $imageIdFieldName;

    /**
     * @var string The fieldname inside the {{luya\admin\aws\ImageSelectCollectionActiveWindow::$refTableName}} to store the reference id where this active is attached.
     */
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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        if ($this->imageIdFieldName === null || $this->refFieldName === null) {
            throw new InvalidConfigException("The properties imageIdFieldName and refFieldName can not be empty.");
        }
    }
    
    /**
     * The default action which is going to be requested when clicking the ActiveWindow.
     *
     * @return string The response string, render and displayed trough the angular ajax request.
     */
    public function index()
    {
        return $this->render('index');
    }

    /**
     * Load all images.
     * 
     * @return array 
     */
    public function callbackLoadAllImages()
    {
        $images = [];
        foreach ((new Query())->select(['image_id' => $this->imageIdFieldName])->where([$this->refFieldName => $this->getItemId()])->from($this->refTableName)->all() as $image) {
            $images[] = Yii::$app->storage->getImage($image['image_id'])->toArray();
        }

        return $images;
    }

    /**
     * Remove a given image id from the index.
     * 
     * @param integer $imageId The image to delete from the index.
     * @return number
     */
    public function callbackRemoveFromIndex($imageId)
    {
        return Yii::$app->db->createCommand()->delete($this->refTableName, [
            $this->imageIdFieldName => (int) $imageId,
            $this->refFieldName => (int) $this->getItemId(),
        ])->execute();
    }

    /**
     * Generate an image for a given file id and store the image in the index.
     * 
     * @param integer $fileId The file id to create the image from and store the image id in the database.
     * @return array
     */
    public function callbackAddImageToIndex($fileId)
    {
        $image = Yii::$app->storage->addImage($fileId);
        
        if (!$image) {
            return $this->sendError("Unable to create image from given file Id.");
        }

        Yii::$app->db->createCommand()->insert($this->refTableName, [
            $this->imageIdFieldName => (int) $image->id,
            $this->refFieldName => (int) $this->getItemId(),
        ])->execute();

        return Yii::$app->storage->getImage($imageId)->toArray();
    }
}
