<?php

namespace admin\storage;

use \admin\models\StorageImage;

class Image
{
    public function create($fileId, $filterId = 0)
    {
        $img = StorageImage::find()->where(['file_id' => $fileId, 'filter_id' => $filterId])->asArray()->one();
        if($img) {
            return $img['id'];
        }   
        $file = \yii::$app->luya->storage->file->getPath($fileId);
        $info = \yii::$app->luya->storage->file->getInfo($fileId);
        $imagine = new \Imagine\Gd\Imagine();
        $image = $imagine->open($file);
        $fileName = $filterId.'_'.$info->name_new_compound;

        if (empty($filterId)) {
            $save = $image->save(\yii::$app->luya->storage->dir.$fileName);
        } else {
            $model = \admin\models\StorageFilter::find()->where(['id' => $filterId])->one();
            if (!$model) {
                throw new \Exception("could not find the provided filter id '$filterId'.");
            }
            $newimage = $model->applyFilter($image, $imagine);
            $save = $newimage->save(\yii::$app->luya->storage->dir.$fileName);
        }

        if ($save) {
            $model = new \admin\models\StorageImage();
            $model->setAttributes([
                'file_id' => $fileId,
                'filter_id' => $filterId,
            ]);
            if ($model->save()) {
                return $model->id;
            }
        }

        return false;
    }

    /**
     * see if the filter for this image already has been applyd, yes return the image_source, otherwise apply
     * filter and return the new image_source.
     *
     * @param int    $imageId
     * @param string $filterIdentifier
     */
    public function filterApply($imageId, $filterIdentifier)
    {
        // resolve $filterIdentifier
        $filter = \admin\models\StorageFilter::find()->where(['identifier' => $filterIdentifier])->asArray()->one();
        if (!$filter) {
            throw new \Exception('could not find the filterIdentifier '.$filterIdentifier);
        }
        $filterId = $filter['id'];

        $image = $this->get($imageId);
        if (!$image) {
            return false;
        }

        $data = (new \yii\db\Query())->from('admin_storage_image')->where(['file_id' => $image->file_id, 'filter_id' => $filterId])->one();

        if ($data) {
            $imageId = $data['id'];
        } else {
            $imageId = $this->create($image->file_id, $filterId);
        }

        return $this->get($imageId);
    }

    // @web/storage/the-originame_name_$filterId_$fileIdf.jpg
    public function get($imageId)
    {
        // get the real full image path to display this file.
        $data = \admin\models\StorageImage::find()->where(['id' => $imageId])->with('file')->one();
        if (!$data) {
            return false;
        }
        $fileName = implode([$data->filter_id, $data->file->name_new_compound], '_');

        return \luya\helpers\ArrayHelper::toObject([
            'filter_id' => $data->filter_id,
            'file_id' => $data->file_id,
            'image_id' => $data->id,
            'file_source' => $data->file->name_new_compound,
            'image_source' => $fileName,
            'source' => \yii::$app->luya->storage->httpDir.$fileName,
        ]);
    }
}
