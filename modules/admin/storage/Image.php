<?
namespace admin\storage;

class Image
{
    public function create($fileId, $filterId = 0)
    {
        $file = \yii::$app->luya->storage->file->getPath($fileId);
        $info = \yii::$app->luya->storage->file->getInfo($fileId);
        $imagine = new \Imagine\Gd\Imagine();
        $image = $imagine->open($file);
        
        $model = \admin\models\StorageFilter::find()->where(['id' => $filterId])->one();
        $image = $model->applyFilter($image);
        
        $fileName = $filterId . '_' . $info->name_new_compound;
        
        
        
        $save = $image->save(\yii::$app->luya->storage->dir . $fileName);
        
        if ($save) {
            $model = new \admin\models\StorageImage();
            $model->setAttributes([
                'file_id' => $fileId,
                'filter_id' => $filterId
            ]);
            if ($model->save()) {
                return $model->id;
            }
        }
        
        return false;
    }
    
    // @web/storage/the-originame_name_$filterId_$fileIdf.jpg
    public function getPath($imageId)
    {
        // get the real full image path to display this file.
    }
}