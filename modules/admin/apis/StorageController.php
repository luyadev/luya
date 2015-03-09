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
            $files[$file['name']] = \yii::$app->luya->storage->file->create($file['tmp_name'], $file['name']);
        }
    
        return $files;
    }
}