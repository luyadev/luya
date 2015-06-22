<?php

namespace admin\apis;

use Yii;

/**
 * @author nadar
 */
class StorageController extends \admin\base\RestController
{
    /**
     * <URL>/admin/api-admin-storage/files-upload.
     *
     * @return array|json Key represents the uploaded file name, value represents the id in the database.
     */
    public function actionFilesUpload()
    {
        $files = [];
        foreach ($_FILES as $k => $file) {
            $create = \yii::$app->storage->file->create($file['tmp_name'], $file['name']);

            $files[$file['name']] = ['id' => $create, 'error' => (bool) !$create, 'message' => \yii::$app->storage->file->getError(), 'file' => ((bool) $create) ? $this->actionFilePath($create) : false];
        }

        return $files;
    }
    
    public function actionFilesUploadFlow()
    {
        try {
            $config = new \Flow\Config();
            $config->setTempDir(\yii::getAlias('@webroot/assets'));
            $request = new \Flow\Request();
        
            $fileName = \yii::getAlias('@webroot/assets').DIRECTORY_SEPARATOR.$request->getFileName();
        
            if (\Flow\Basic::save($fileName, $config, $request)) {
                // file saved successfully and can be accessed at './final_file_destination'
                $folderId = Yii::$app->request->post('folderId', 0);
                $fileId = \yii::$app->storage->file->create($fileName, $request->getFileName(), false, (int) $folderId);
        
                @unlink($fileName);
        
                return $fileId;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function actionImageUpload()
    {
        $fileId = \yii::$app->request->post('fileId', null);
        $filterId = \yii::$app->request->post('filterId', null);

        $create = \yii::$app->storage->image->create($fileId, $filterId);
        $msg = (!$create) ? 'Error while uploading image and/or store to database.' : 'Upload successfull';
        return ['id' => $create, 'error' => (bool) !$create, 'message' => $msg, 'image' => ((bool) $create) ? $this->actionImagePath($create) : false];
    }

    public function actionImagePath($imageId)
    {
        return \yii::$app->storage->image->get($imageId);
    }

    public function actionFilePath($fileId)
    {
        return \yii::$app->storage->file->get($fileId);
    }

    public function actionFiles($folderId = 0)
    {
        return [
            'breadcrumbs' => Yii::$app->storage->folder->breadcrumbs($folderId),
            'folders' => Yii::$app->storage->folder->getSubFolders($folderId),
            'files' => Yii::$app->storage->file->allFromFolder($folderId),
        ];
    }

    public function actionFolderCreate()
    {
        $folderName = Yii::$app->request->post('folderName', null);
        $parentFolderId = Yii::$app->request->post('parentFolderId', 0);

        return Yii::$app->storage->folder->createFolder($folderName, $parentFolderId);
    }
}
