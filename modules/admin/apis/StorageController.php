<?php

namespace admin\apis;

use Yii;

/**
 * @author nadar
 */
class StorageController extends \admin\base\RestController
{
    private $_uploaderErrors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    ];

    /**
     * <URL>/admin/api-admin-storage/files-upload.
     *
     * @todo change post_max_size = 20M
     * @todo change upload_max_filesize = 20M
     * @todo http://php.net/manual/en/features.file-upload.errors.php
     *
     * @return array|json Key represents the uploaded file name, value represents the id in the database.
     */
    public function actionFilesUpload()
    {
        $files = [];
        foreach ($_FILES as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => $this->_uploaderErrors[$file['error']]];
            }
            $create = Yii::$app->storage->file->create($file['tmp_name'], $file['name'], false, Yii::$app->request->post('folderId', 0));
            if ($create) {
                return ['upload' => true, 'message' => 'file uploaded succesfully'];
            } else {
                return ['upload' => false, 'message' => Yii::$app->storage->file->getError()];
            }
        }

        return ['upload' => false, 'message' => 'no files selected'];
    }

    public function actionFilesDelete()
    {
        foreach (Yii::$app->request->post('ids', []) as $id) {
            if (!Yii::$app->storage->file->delete($id)) {
                return false;
            }
        }

        return true;
    }

    public function actionFilesMove()
    {
        $toFolderId = Yii::$app->request->post('toFolderId', 0);
        $fileIds = Yii::$app->request->post('fileIds', []);

        return Yii::$app->storage->file->moveFilesToFolder($fileIds, $toFolderId);
    }

    /*
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
    */

    public function actionImageUpload()
    {
        $fileId = Yii::$app->request->post('fileId', null);
        $filterId = Yii::$app->request->post('filterId', null);

        $create = Yii::$app->storage->image->create($fileId, $filterId);
        $msg = (!$create) ? 'Error while uploading image and/or store to database.' : 'Upload successfull';

        return ['id' => $create, 'error' => (bool) !$create, 'message' => $msg, 'image' => ((bool) $create) ? $this->actionImagePath($create) : false];
    }
    
    public function actionAllImagePaths()
    {
        return Yii::$app->storage->image->all();
    }

    public function actionImagePath($imageId)
    {
        return Yii::$app->storage->image->get($imageId);
    }
    
    public function actionAllFilePaths()
    {
        return Yii::$app->storage->file->all();
    }

    public function actionFilePath($fileId)
    {
        return Yii::$app->storage->file->get($fileId);
    }

    public function actionAllFolderFiles()
    {
        $data = [];
        $data[] = ['folder' => ['id' => 0], 'items' => Yii::$app->storage->file->allFromFolder(0)];
        foreach(Yii::$app->storage->folder->all() as $folder) {
            $data[] = ['folder' => $folder, 'items' => Yii::$app->storage->file->allFromFolder($folder['id'])];
        }
        return $data;
    }
    
    public function actionGetFiles($folderId)
    {
        return Yii::$app->storage->file->allFromFolder($folderId);
    }

    public function actionGetFolders()
    {
        return Yii::$app->storage->folder->getFolderTree();
    }

    public function actionFolderCreate()
    {
        $folderName = Yii::$app->request->post('folderName', null);
        $parentFolderId = Yii::$app->request->post('parentFolderId', 0);

        return Yii::$app->storage->folder->createFolder($folderName, $parentFolderId);
    }

    public function actionFolderUpdate($folderId)
    {
        return Yii::$app->storage->folder->updateFolder($folderId, Yii::$app->request->post());
    }

    public function actionFolderDelete($folderId)
    {
        return Yii::$app->storage->folder->deleteFolder($folderId);
    }
}
