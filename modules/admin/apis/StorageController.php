<?php

namespace admin\apis;

use Yii;
use Exception;
use admin\helpers\Storage;
use admin\models\StorageImage;
use admin\models\StorageFile;
use admin\models\StorageFolder;

use admin\storage\FolderQuery;
use admin\storage\ImageQuery;
use admin\storage\FileQuery;

/**
 * @author nadar
 */
class StorageController extends \admin\base\RestController
{
    // new beta2 controller meethods
    
    public function actionDataFolders()
    {
        $folders = [];
        foreach((new FolderQuery())->all() as $folder) {
            $folders[] = $folder->toArray();
        }
        
        return $folders;
    }
    
    public function actionDataFiles()
    {
        $files = [];
        foreach((new FileQuery())->where(['is_hidden' => 0, 'is_deleted' => 0])->all() as $file) {
            
            $data = $file->toArray();
            if ($file->isImage) {
                $filter = Yii::$app->storage->getFiltersArrayItem('tiny-thumbnail');
                if ($filter) {
                    $thumbnail = Yii::$app->storage->addImage($file->id, $filter['id']);
                    if ($thumbnail) {
                        $data['thumbnail'] = $thumbnail->toArray();
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
        foreach((new ImageQuery())->all() as $image) {
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
            return ['error' => true, 'message' => 'error while creating image: ' . $err->getMessage()];
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
        $files = [];
        foreach ($_FILES as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => $this->_uploaderErrors[$file['error']]];
            }
            try {
                $create = Yii::$app->storage->addFile($file['tmp_name'], $file['name'], Yii::$app->request->post('folderId', 0));
                return ['upload' => true, 'message' => 'file uploaded succesfully'];
            } catch(Exception $err) {
                return ['upload' => false, 'message' => $err->getMessage()];
            }
        }
    
        return ['upload' => false, 'message' => 'no files selected'];
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
    
    // old controller methods

    /*
    public function actionFilesMove()
    {
        $toFolderId = Yii::$app->request->post('toFolderId', 0);
        $fileIds = Yii::$app->request->post('fileIds', []);

        return Storage::moveFilesToFolder($fileIds, $toFolderId);
    }
    */

    /*
    public function actionImageUpload()
    {
        $fileId = Yii::$app->request->post('fileId', null);
        $filterId = Yii::$app->request->post('filterId', null);

        try {
            $create = Yii::$app->storage->addImage($fileId, $filterId);
            return ['id' => $create->id, 'error' => false, 'message' => 'upload ok', 'image' => $create->source];
        } catch (Exception $err) {
            return ['id' => 0, 'error' => true, 'message' => 'error while creating image: ' . $err->getMessage(), 'image' => null];
        }
    }
    */
    
    // until here new storage

    /*
    
    public function actionAllImagePaths()
    {
        $images = [];
        foreach (StorageImage::find()->asArray()->all() as $imageRow) {
            $img = Yii::$app->storage->getImage($imageRow['id']);
            if ($img) {
                $images[] = $img->toArray();
            }
        }

        return $images;
    }

    public function actionImagePath($imageId)
    {
        return Yii::$app->storage->getImage($imageId)->toArray();
    }

    public function actionAllFilePaths()
    {
        return $this->filesAll();
    }

    public function actionFilePath($fileId)
    {
        return Yii::$app->storage->getFile($fileId)->toArray();
    }

    public function actionAllFolderFiles()
    {
        $data = [];
        
        $data[] = ['folder' => ['id' => 0], 'items' => $this->actionGetFiles(0)];
        
        foreach ($this->filesAll() as $folder) {
            $data[] = ['folder' => $folder, 'items' => $this->actionGetFiles($folder['id'])];
        }

        return $data;
    }

    public function actionGetFiles($folderId)
    {
        $files = [];
        foreach(Yii::$app->storage->findFiles(['folder_id' => $folderId]) as $file) {
            $imageData = false;
            $thumbnail = false;
            $error = false;
            
            if ($file->isImage) {
                $image = $file->noFilterImage;
                $imageData = $image->toArray();
                if ($image) {
                    $thumbImage = $image->applyFilter('tiny-thumbnail');
                    if ($thumbImage) {
                        $thumbnail = $thumbImage->toArray();
                    }
                }
            }
            
            
            $files[] = [
                'file_data' => $file->toArray(),
                'image_data' => $imageData,
                'thumbnail_data' => $thumbnail,
            ];
        }
        return $files;
    }

    public function actionGetFolders()
    {
        return $this->helperGetFolderTree();
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

    // here
    
    

    

    */
    
    // helpers as of removment
    
    /*
    private function filesAllFromFolder($folderId)
    {
        $files = StorageFile::find()->select(['admin_storage_file.id', 'name_original', 'extension', 'file_size', 'upload_timestamp', 'firstname', 'lastname'])->leftJoin('admin_user', 'admin_user.id=admin_storage_file.upload_user_id')->where(['folder_id' => $folderId, 'is_hidden' => 0, 'admin_storage_file.is_deleted' => 0])->asArray()->all();
    
        return $this->internalListData($files);
    }

    private function filesAll()
    {
        $files = StorageFile::find()->select(['admin_storage_file.id', 'name_original', 'extension', 'file_size', 'upload_timestamp', 'firstname', 'lastname'])->leftJoin('admin_user', 'admin_user.id=admin_storage_file.upload_user_id')->where(['is_hidden' => 0, 'admin_storage_file.is_deleted' => 0])->asArray()->all();
    
        return $this->internalListData($files);
    }
    
    private function internalListData($files)
    {
        foreach ($files as $k => $v) {
            // @todo check fileHasImage sth
            if ($v['extension'] == 'jpg' || $v['extension'] == 'png') {
                $isImage = true;
                
                try {
                    $image = Yii::$app->storage->addImage($v['id'], 0);
                    
                    if ($image) {
                        $thumb = $image->applyFilter('tiny-thumbnail');
                        if ($thumb) {
                            $thumb->toArray();
                        }
                        $originalImage = $image->toArray();
                    } else {
                        $thumb = false;
                        $originalImage = false;
                    }
                } catch(Exception $e) {
                    $thumb = false;
                    $originalImage = false;
                }
            } else {
                $isImage = false;
                $thumb = false;
                $originalImage = false;
            }
            $files[$k]['is_image'] = $isImage;
            $files[$k]['thumbnail'] = $thumb;
            $files[$k]['original_image'] = $originalImage;
            $files[$k]['file_data'] = Yii::$app->storage->getFile($v['id']);
        }
    
        return $files;
    }
    */
    // folder helper
    
    /*
    private function helperFolderPartialFolderTree($parentId)
    {
        $data = [];
        foreach ($this->helperGetSubFolders($parentId) as $row) {
            $data[] = [
                'data' => $row,
                '__items' => $this->helperFolderPartialFolderTree($row['id']),
            ];
        }
    
        return $data;
    }
    
    public function helperGetFolderTree()
    {
        return $this->helperFolderPartialFolderTree(0);
    }
    
    public function helperGetSubFolders($parentFolderId)
    {
        return \admin\models\StorageFolder::find()->where(['parent_id' => $parentFolderId, 'is_deleted' => 0])->asArray()->all();
    }
    */
}
