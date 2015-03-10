<?php

namespace admin\apis;

/**
 * @author nadar
 *
 */
class StorageController extends \admin\base\RestController
{
    /**
     * <URL>/admin/api-admin-storage/files-upload
     * 
     * @return array|json Key represents the uploaded file name, value represents the id in the database.
     */
    public function actionFilesUpload()
    {
        $files = [];
        foreach ($_FILES as $k => $file) {
            
            $create = \yii::$app->luya->storage->file->create($file['tmp_name'], $file['name']);
            
            $files[$file['name']] = ['id' => $create, 'error' => (bool) !$create, 'message' => \yii::$app->luya->storage->file->getError()];
        }
    
        return $files;
    }
    
    public function actionImageUpload()
    {
        $fileId = \yii::$app->request->post('fileId', null);
        $filterId = \yii::$app->request->post('filterId', null);
        
        $create = \yii::$app->luya->storage->image->create($fileId, $filterId);
        
        return ['id' => $create, 'error' => (bool) !$create, 'message' => '...'];
    }
}