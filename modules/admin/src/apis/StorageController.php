<?php

namespace luya\admin\apis;

use Yii;
use Exception;
use luya\admin\helpers\Storage;
use luya\admin\models\StorageFile;
use luya\admin\models\StorageFolder;
use luya\admin\Module;
use luya\traits\CacheableTrait;
use yii\caching\DbDependency;
use luya\admin\helpers\I18n;
use luya\admin\base\RestController;

/**
 * Storage API, provides data from system image, files, filters and folders to build the filemanager, allows create/delete process to manipulate storage data.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class StorageController extends RestController
{
    use CacheableTrait;
    
    // new beta2 controller meethods

    protected function flushApiCache()
    {
        Yii::$app->storage->flushArrays();
        $this->deleteHasCache('storageApiDataFolders');
        $this->deleteHasCache('storageApiDataFiles');
        $this->deleteHasCache('storageApiDataImages');
    }
    
    // DATA READERS

    public function actionDataFolders()
    {
        $cache = $this->getHasCache('storageApiDataFolders');
        
        if ($cache === false) {
            $folders = [];
            foreach (Yii::$app->storage->findFolders() as $key => $folder) {
                $folders[$key] = $folder->toArray();
                $folders[$key]['toggle_open'] = (int) Yii::$app->adminuser->identity->setting->get('foldertree.'.$folder->id);
                $folders[$key]['subfolder'] = Yii::$app->storage->getFolder($folder->id)->hasChild();
            }
            
            $this->setHasCache('storageApiDataFolders', $folders, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_folder WHERE is_deleted=0']), 0);
            
            return $folders;
        }
        
        return $cache;
    }
    
    public function actionDataFiles()
    {
        $cache = $this->getHasCache('storageApiDataFiles');
        
        if ($cache === false) {
            $files = [];
            foreach (Yii::$app->storage->findFiles(['is_hidden' => 0, 'is_deleted' => 0]) as $file) {
                $data = $file->toArray();
                if ($file->isImage) {
                    // add tiny thumbnail
                    $filter = Yii::$app->storage->getFiltersArrayItem('tiny-crop');
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
            $this->setHasCache('storageApiDataFiles', $files, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_file WHERE is_deleted=0']), 0);
            return $files;
        }
        
        return $cache;
    }
    
    public function actionDataImages()
    {
        $cache = $this->getHasCache('storageApiDataImages');
        
        if ($cache === false) {
            $images = [];
            foreach (Yii::$app->storage->findImages() as $image) {
                if (!$image->file->isHidden && !$image->file->isDeleted) {
                    $images[] = $image->toArray();
                }
            }
            $this->setHasCache('storageApiDataImages', $images, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_image']), 0);
            return $images;
        }
        
        return $cache;
    }
    
    // ACTIONS

    public function actionFilemanagerUpdateCaption()
    {
        $fileId = Yii::$app->request->post('id', false);
        $captionsText = Yii::$app->request->post('captionsText', false);
    
        if ($fileId && $captionsText) {
            $model = StorageFile::findOne($fileId);
            if ($model) {
                $model->updateAttributes([
                    'caption' => I18n::encode($captionsText),
                ]);
    
                $this->flushApiCache();
    
                return true;
            }
        }
    
        return false;
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
                $file = Yii::$app->storage->addFile($file['tmp_name'], $file['name'], Yii::$app->request->post('folderId', 0));
                if ($file) {
                    return ['upload' => true, 'message' => Module::t('api_storage_file_upload_succes')];
                }
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
        
        $response = Storage::moveFilesToFolder($fileIds, $toFolderId);
        $this->flushApiCache();
        return $response;
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
        
        $this->flushApiCache();
        
        return $model->update();
    }
    
    public function actionFolderUpdate($folderId)
    {
        $model = StorageFolder::findOne($folderId);
        if (!$model) {
            return false;
        }
        $model->attributes = Yii::$app->request->post();
    
        $this->flushApiCache();
        
        return $model->update();
    }
    
    public function actionFolderCreate()
    {
        $folderName = Yii::$app->request->post('folderName', null);
        $parentFolderId = Yii::$app->request->post('parentFolderId', 0);
        $response = Yii::$app->storage->addFolder($folderName, $parentFolderId);
        $this->flushApiCache();
        return $response;
    }
}
