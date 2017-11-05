<?php

namespace luya\admin\aws;

use Yii;
use luya\admin\ngrest\base\ActiveWindow;
use yii\base\InvalidConfigException;
use yii\db\Query;
use luya\admin\filters\MediumCrop;

/**
 * Create an Active Window where you can select Images and store them into a Ref Table.
 *
 * Usage example of registering Gallery Active Window:
 *
 * ```php
 * public function ngRestActiveWindows()
 * {
 *     return [
 *         [
 *          'class' => 'admin\aws\ImageCollectionActiveWindow',
 *          'refTableName' => 'gallery_album_image',
 *          'imageIdFieldName' => 'image_id',
 *          'refFieldName' => 'album_id',
 *          'sortIndexFieldName' => 'sortindex',
 *         ],
 *     ];
 * }
 * ```
 *
 * The above example would required the following migration code for the ref table:
 *
 * ```php
 * $this->createTable("gallery_album_image", [
 *     "image_id" => $this->integer()->notNull(),
 *     "album_id" => $this->integer()->notNull(),
 *     "sortindex" => $this->integer()->defaultValue(0),
 * ]);
 * ```
 *
 * If you have a table without sortindex field, the {{ImageSelectCollectionActiveWindow::$sortIndex}} is disable by default. You have to define
 * this attribute in order to enable sorting.
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
     * @var string The name of the field which contains the sort index for the current reference entry, if no value is given the sort ability is disabled.
     */
    public $sortIndexFieldName;

    /**
     * @var string The name of the module where the active windows is located in order to finde the view path.
     */
    public $module = 'admin';

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
        return $this->render('index', [
            'sortIndexFieldName' => $this->sortIndexFieldName,
        ]);
    }
    
    /**
     * @inheritdoc
     */
    public function defaultIcon()
    {
        return 'photo_library';
    }

    /**
     * Load all images.
     *
     * @return array
     */
    public function callbackLoadAllImages()
    {
        $query = (new Query())
            ->select(['image_id' => $this->imageIdFieldName])
            ->where([$this->refFieldName => $this->getItemId()])
            ->from($this->refTableName);
        
        if ($this->isSortEnabled()) {
            $query->orderBy([$this->sortIndexFieldName => SORT_ASC]);
        }
            
        $data = $query->all();
        $images = [];
        foreach ($data as $image) {
            $images[] = $this->getImageArray($image['image_id']);
        }

        return $images;
    }
    
    /**
     * Get the image array for a given image id.
     *
     * @param integer $imageId
     * @return array
     */
    private function getImageArray($imageId)
    {
        $array = Yii::$app->storage->getImage($imageId)->applyFilter(MediumCrop::identifier())->toArray();
        
        $array['originalImageId'] = $imageId;
        
        return $array;
    }

    /**
     * Whether sorting is enabled and provided or not.
     * @return boolean
     */
    public function isSortEnabled()
    {
        return !empty($this->sortIndexFieldName);
    }
    
    /**
     * Returns the max (highest) value from sort.
     * @return mixed|boolean|string
     */
    public function getMaxSortIndex()
    {
        return (new Query())->from($this->refTableName)->where([$this->refFieldName => $this->itemId])->max($this->sortIndexFieldName);
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

        Yii::$app->db->createCommand()->insert($this->refTableName, $this->prepareInsertFields([
            $this->imageIdFieldName => (int) $image->id,
            $this->refFieldName => (int) $this->itemId,
        ]))->execute();

        return $this->getImageArray($image->id);
    }
    
    /**
     * Switch position between two images.
     *
     * @param integer $new
     * @param integer $old
     * @return boolean
     */
    public function callbackChangeSortIndex($new, $old)
    {
        // get old position
        $newPos = (new Query)->select([$this->sortIndexFieldName])->from($this->refTableName)->where([$this->imageIdFieldName => $new['originalImageId']])->scalar();
        $oldPos = (new Query)->select([$this->sortIndexFieldName])->from($this->refTableName)->where([$this->imageIdFieldName => $old['originalImageId']])->scalar();
        
        // switch positions
        $changeNewPos = Yii::$app->db->createCommand()->update($this->refTableName, [$this->sortIndexFieldName => $oldPos], [
            $this->imageIdFieldName => $new['originalImageId'],
            $this->refFieldName => $this->itemId,
        ])->execute();
        
        $changeOldPos = Yii::$app->db->createCommand()->update($this->refTableName, [$this->sortIndexFieldName => $newPos], [
            $this->imageIdFieldName => $old['originalImageId'],
            $this->refFieldName => $this->itemId,
        ])->execute();
        
        return true;
    }
    
    /**
     * Prepare and parse the insert fields for a given array.
     *
     * if sort is enabled, the latest sort index is provided.
     *
     * @param array $fields
     * @return number
     */
    public function prepareInsertFields(array $fields)
    {
        if ($this->isSortEnabled()) {
            $fields[$this->sortIndexFieldName] = $this->getMaxSortIndex() + 1;
        }
        
        return $fields;
    }
}
