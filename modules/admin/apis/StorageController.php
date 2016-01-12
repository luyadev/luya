<?php

namespace admin\apis;

use Yii;
use Exception;
use admin\helpers\Storage;
use admin\models\StorageImage;
use admin\models\StorageFile;
use admin\models\StorageFolder;
use admin\Module;

/**
 * @author nadar
 */
class StorageController extends \admin\base\RestController
{
    // new beta2 controller meethods

    public function actionDataFolders()
    {
        $folders = [];
        foreach (Yii::$app->storage->findFolders() as $folder) {
            $folders[] = $folder->toArray();
        }
        
        return $folders;
    }
    
    public function actionDataFiles()
    {
        $files = [];
        foreach (Yii::$app->storage->findFiles(['is_hidden' => 0, 'is_deleted' => 0]) as $file) {
            $data = $file->toArray();
            if ($file->isImage) {
                // add tiny thumbnail
                $filter = Yii::$app->storage->getFiltersArrayItem('tiny-thumbnail');
                if ($filter) {
                    $thumbnail = Yii::$app->storage->addImage($file->id, $filter['id']);
                    if ($thumbnail) {
                        $data['thumbnail'] = $thumbnail->toArray();
                    }
                }
                // add meidum thumbnail
                $filter = Yii::$app->storage->getFiltersArrayItem('medium-thumbnail');
                if ($filter) {
                    $thumbnail = Yii::$app->storage->addImage($file->id, $filter['id']);
                    if ($thumbnail) {
                        $data['thumbnailMedium'] = $thumbnail->toArray();
                    }
                }
            }
            $files[] = $data;
        }
        
        return $files;
    }
    
    public function actionDataImages()
    {
        $images = [];
        foreach (Yii::$app->storage->findImages() as $image) {
            $images[] = $image->toArray();
        }
        
        return $images;
    }
    
    public function actionImageUpload()
    {
        try {
            $create = Yii::$app->storage->addImage(Yii::$app->request->post('fileId', null), Yii::$app->request->post('filterId', null), true);
            if ($create) {
                return ['error' => false, 'id' => $create->id];
            }
        } catch (Exception $err) {
            return ['error' => true, 'message' => Module::t('api_storage_image_upload_error', ['error' => $err->getMessage()])];
        }
    }
    
    public function actionDataFilters()
    {
        return Yii::$app->storage->filtersArray;
    }
    
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
        foreach ($_FILES as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => $this->_uploaderErrors[$file['error']]];
            }
            try {
                Yii::$app->storage->addFile($file['tmp_name'], $file['name'], Yii::$app->request->post('folderId', 0));
                return ['upload' => true, 'message' => Module::t('api_storage_file_upload_succes')];
            } catch (Exception $err) {
                return ['upload' => false, 'message' => Module::t('api_sotrage_file_upload_error', ['error' => $err->getMessage()])];
            }
        }
    
        return ['upload' => false, 'message' => Module::t('api_sotrage_file_upload_empty_error')];
    }
    
    public function actionFilemanagerMoveFiles()
    {
        $toFolderId = Yii::$app->request->post('toFolderId', 0);
        $fileIds = Yii::$app->request->post('fileIds', []);
        
        return Storage::moveFilesToFolder($fileIds, $toFolderId);
    }
    
    public function actionFilemanagerRemoveFiles()
    {
        foreach (Yii::$app->request->post('ids', []) as $id) {
            if (!Storage::removeFile($id)) {
                return false;
            }
        }
    
        return true;
    }
    
    /**
     * check if a folder is empty (no subfolders/no files).
     *
     * @param int $folderId
     *
     * @return bool
     */
    public function actionIsFolderEmpty($folderId)
    {
        $count = Yii::$app->storage->getFolder($folderId)->getFilesCount();
        if ($count > 0) {
            return false;
        }
        
        return true;
    }
    
    /**
     * delete folder, all subfolders and all included files.
     *
     * 1. search another folders with matching parentIds and call deleteFolder on them
     * 2. get all included files and delete them
     * 3. delete folder
     *
     * @param int $folderId
     * @todo move to storage helpers?
     * @return bool
     */
    public function actionFolderDelete($folderId)
    {
        // find all subfolders
        $matchingChildFolders = StorageFolder::find()->where(['parent_id' => $folderId])->asArray()->all();
        foreach ($matchingChildFolders as $matchingChildFolder) {
            $this->actionFolderDelete($matchingChildFolder['id']);
        }
        
        // find all attached files and delete them
        $folderFiles = StorageFile::find()->where(['folder_id' => $folderId])->all();
        foreach ($folderFiles as $folderFile) {
            $folderFile->delete();
        }
        
        // delete folder
        $model = StorageFolder::findOne($folderId);
        if (!$model) {
            return false;
        }
        $model->is_deleted = true;
        
        Yii::$app->storage->deleteHasCache(Yii::$app->storage->folderCacheKey);
        
        return $model->update();
    }
    
    public function actionFolderUpdate($folderId)
    {
        $model = StorageFolder::findOne($folderId);
        if (!$model) {
            return false;
        }
        $model->attributes = Yii::$app->request->post();
    
        return $model->update();
    }
    
    public function actionFolderCreate()
    {
        $folderName = Yii::$app->request->post('folderName', null);
        $parentFolderId = Yii::$app->request->post('parentFolderId', 0);
    
        $model = new StorageFolder();
        $model->name = $folderName;
        $model->parent_id = $parentFolderId;
        $model->timestamp_create = time();
    
        return $model->save();
    }
}
