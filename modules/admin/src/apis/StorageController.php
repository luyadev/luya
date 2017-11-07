<?php

namespace luya\admin\apis;

use Yii;
use luya\Exception;
use luya\admin\helpers\Storage;
use luya\admin\models\StorageFile;
use luya\admin\models\StorageFolder;
use luya\admin\Module;
use luya\traits\CacheableTrait;
use luya\admin\helpers\I18n;
use luya\admin\base\RestController;
use yii\caching\DbDependency;
use luya\admin\filters\TinyCrop;
use luya\admin\filters\MediumThumbnail;
use luya\helpers\FileHelper;
use yii\web\BadRequestHttpException;

/**
 * Filemanager and Storage API.
 *
 * Storage API, provides data from system image, files, filters and folders to build the filemanager, allows create/delete process to manipulate storage data.
 *
 * The storage controller is used to make the luya angular file manager work with the {{luya\admin\storage\BaseFileSystemStorage}}.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class StorageController extends RestController
{
    use CacheableTrait;
    
    /**
     * Flush the storage caching data.
     */
    protected function flushApiCache()
    {
        Yii::$app->storage->flushArrays();
        $this->deleteHasCache('storageApiDataFolders');
        $this->deleteHasCache('storageApiDataFiles');
        $this->deleteHasCache('storageApiDataImages');
    }
    
    // DATA READERS

    /**
     * Get all folders from the storage component.
     *
     * @return array
     */
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
            
            $this->setHasCache('storageApiDataFolders', $folders, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_folder WHERE is_deleted=false']), 0);
            
            return $folders;
        }
        
        return $cache;
    }
    
    /**
     * Get all files from the storage container.
     *
     * @return array
     */
    public function actionDataFiles()
    {
        $cache = $this->getHasCache('storageApiDataFiles');
        
        if ($cache === false) {
            $files = [];
            foreach (Yii::$app->storage->findFiles(['is_hidden' => false, 'is_deleted' => false]) as $file) {
                $data = $file->toArray();
                if ($file->isImage) {
                    // add tiny thumbnail
                    $filter = Yii::$app->storage->getFiltersArrayItem(TinyCrop::identifier());
                    if ($filter) {
                        $thumbnail = Yii::$app->storage->addImage($file->id, $filter['id']);
                        if ($thumbnail) {
                            $data['thumbnail'] = $thumbnail->toArray();
                        }
                    }
                    // add meidum thumbnail
                    $filter = Yii::$app->storage->getFiltersArrayItem(MediumThumbnail::identifier());
                    if ($filter) {
                        $thumbnail = Yii::$app->storage->addImage($file->id, $filter['id']);
                        if ($thumbnail) {
                            $data['thumbnailMedium'] = $thumbnail->toArray();
                        }
                    }
                }
                $files[] = $data;
            }
            $this->setHasCache('storageApiDataFiles', $files, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_file WHERE is_deleted=false']), 0);
            return $files;
        }
        
        return $cache;
    }
    
    /**
     * Get all images from the storage container.
     *
     * @return array
     */
    public function actionDataImages()
    {
        $cache = $this->getHasCache('storageApiDataImages');
        
        if ($cache === false) {
            $images = [];
            foreach (Yii::$app->storage->findImages() as $image) {
                if (!empty($image->file) && !$image->file->isHidden && !$image->file->isDeleted) {
                    $images[] = $image->toArray();
                }
            }
            $this->setHasCache('storageApiDataImages', $images, new DbDependency(['sql' => 'SELECT MAX(id) FROM admin_storage_image']), 0);
            return $images;
        }
        
        return $cache;
    }
    
    // ACTIONS

    /**
     * Update the caption of storage file.
     *
     * @return boolean
     */
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
    
    /**
     * Upload an image to the filemanager.
     *
     * @return array
     */
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
    
    /**
     * Get all available registered filters.
     *
     * @return array
     */
    public function actionDataFilters()
    {
        return Yii::$app->storage->filtersArray;
    }
    
    /**
     * Action to replace a current file with a new.
     *
     * @return boolean
     */
    public function actionFileReplace()
    {
        $fileId = Yii::$app->request->post('fileId', false);
        $raw = $_FILES['file'];
        /** @var $file \luya\admin\file\Item */
        if ($file = Yii::$app->storage->getFile($fileId)) {
            $serverSource = $file->getServerSource();
            if (is_uploaded_file($raw['tmp_name'])) {
                
                // check for same extension / mimeType
                $fileData = Yii::$app->storage->ensureFileUpload($raw['tmp_name'], $raw['name']);
                
                if ($fileData['mimeType'] != $file->mimeType) {
                    throw new BadRequestHttpException("The type must be the same as the original file in order to replace.");
                }
                
                if (Storage::replaceFile($serverSource, $raw['tmp_name'], $raw['name'])) {
                    foreach (Yii::$app->storage->findImages(['file_id' => $file->id]) as $img) {
                        Storage::removeImage($img->id, false);
                    }
                    
                    // calculate new file files based on new file
                    $model = StorageFile::findOne($fileId);
                    $fileHash = FileHelper::md5sum($serverSource);
                    $fileSize = @filesize($serverSource);
                    $model->updateAttributes([
                        'hash_file' => $fileHash,
                        'file_size' => $fileSize,
                        'upload_timestamp' => time(),
                    ]);
                    $this->flushApiCache();
                    
                    return true;
                }
            }
        }
        
        return false;
    }
    
    
    /**
     * Upload a new file from $_FILES array.
     *
     * @return array An array with upload and message key.
    */
    public function actionFilesUpload()
    {
        foreach ($_FILES as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => Storage::getUploadErrorMessage($file['error'])];
            }
            try {
                $response = Yii::$app->storage->addFile($file['tmp_name'], $file['name'], Yii::$app->request->post('folderId', 0));
                if ($response) {
                    return ['upload' => true, 'message' => Module::t('api_storage_file_upload_succes')];
                } else {
                    return ['upload' => false, 'message' => Module::t('api_storage_file_upload_folder_error')];
                }
            } catch (Exception $err) {
                return ['upload' => false, 'message' => Module::t('api_sotrage_file_upload_error', ['error' => $err->getMessage()])];
            }
        }
    
        // If the files array is empty, this is an indicator for exceeding the upload_max_filesize from php ini
        return ['upload' => false, 'message' => Storage::getUploadErrorMessage(UPLOAD_ERR_INI_SIZE)];
    }
    
    /**
     * Move files into another folder.
     *
     * @return boolean
     */
    public function actionFilemanagerMoveFiles()
    {
        $toFolderId = Yii::$app->request->post('toFolderId', 0);
        $fileIds = Yii::$app->request->post('fileIds', []);
        
        $response = Storage::moveFilesToFolder($fileIds, $toFolderId);
        $this->flushApiCache();
        return $response;
    }
    
    /**
     * Remove files from the storage component.
     *
     * @todo make permission check.
     * @return boolean
     */
    public function actionFilemanagerRemoveFiles()
    {
        foreach (Yii::$app->request->post('ids', []) as $id) {
            if (!Storage::removeFile($id)) {
                return false;
            }
        }
        $this->flushApiCache();
        return true;
    }
    
    /**
     * Check whether a folder is empty or not in order to delete this folder.
     *
     * @param integer $folderId The folder id to check whether it has files or not.
     * @return boolean
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
     * @param integer $folderId The folder to delete.
     * @todo move to storage helpers?
     * @return boolean
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
    
    /**
     * Update the folder model data.
     *
     * @param integer $folderId The folder id.
     * @return boolean
     */
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
    
    /**
     * Create a new folder pased on post data.
     *
     * @return boolean
     */
    public function actionFolderCreate()
    {
        $folderName = Yii::$app->request->post('folderName', null);
        $parentFolderId = Yii::$app->request->post('parentFolderId', 0);
        $response = Yii::$app->storage->addFolder($folderName, $parentFolderId);
        $this->flushApiCache();
        return $response;
    }
}
