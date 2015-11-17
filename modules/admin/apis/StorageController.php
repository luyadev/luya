<?php

namespace admin\apis;

use Yii;
use Exception;
use admin\helpers\Storage;
use admin\models\StorageImage;
use admin\models\StorageFile;
use admin\models\StorageFolder;

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
            try {
                $create = Yii::$app->storagecontainer->addFile($file['tmp_name'], $file['name'], Yii::$app->request->post('folderId', 0));
                return ['upload' => true, 'message' => 'file uploaded succesfully'];
            } catch(Exception $err) {
                return ['upload' => false, 'message' => $err->getMessage()];
            }
        }

        return ['upload' => false, 'message' => 'no files selected'];
    }

    public function actionFilesDelete()
    {
        foreach (Yii::$app->request->post('ids', []) as $id) {
            if (!Storage::removeFile($id)) {
                return false;
            }
        }

        return true;
    }

    public function actionFilesMove()
    {
        $toFolderId = Yii::$app->request->post('toFolderId', 0);
        $fileIds = Yii::$app->request->post('fileIds', []);

        return Storage::moveFilesToFolder($fileIds, $toFolderId);
    }

    public function actionImageUpload()
    {
        $fileId = Yii::$app->request->post('fileId', null);
        $filterId = Yii::$app->request->post('filterId', null);

        try {
            $create = Yii::$app->storagecontainer->addImage($fileId, $filterId);
            
        } catch (Exception $err) {
            return ['id' => 0, 'error' => true, 'message' => 'error while creating image: ' . $err->getMessage(), 'image' => null];
        }
        
        return ['id' => $create->id, 'error' => false, 'message' => 'upload ok', 'image' => $create->source];
    }
    
    // until here new storage

    public function actionAllImagePaths()
    {
        $images = [];
        foreach (StorageImage::find()->asArray()->all() as $imageRow) {
            $img = $this->get($imageRow['id']);
            if ($img) {
                $images[] = $img;
            }
        }

        return $images;
    }

    public function actionImagePath($imageId)
    {
        return Yii::$app->storagecontainer->getImage($imageId)->source;
    }

    public function actionAllFilePaths()
    {
        return $this->filesAll();
    }

    public function actionFilePath($fileId)
    {
        return Yii::$app->storagecontainer->getFile($fileId)->source;
    }

    public function actionAllFolderFiles()
    {
        $data = [];
        
        $data[] = ['folder' => ['id' => 0], 'items' => $this->filesAllFromFolder(0)];
        
        foreach ($this->filesAll() as $folder) {
            $data[] = ['folder' => $folder, 'items' => $this->filesAllFromFolder($folder['id'])];
        }

        return $data;
    }

    public function actionGetFiles($folderId)
    {
        return $this->filesAllFromFolder($folderId);
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
    
    public function actionFolderUpdate($folderId)
    {
        $model = StorageFolder::findOne($folderId);
        if (!$model) {
            return false;
        }
        $model->attributes = Yii::$app->request->post();
        
        return $model->update();
    }

    /**
     * delete folder, all subfolders and all files included.
     *
     * @param int $folderId
     *
     * @return bool
     */
    public function actionFolderDelete($folderId)
    {
        return $this->helperDeleteFolder($folderId);
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
        return $this->helperIsEmptyFolder($folderId);
    }
    
    // helpers as of removment
    
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
                    $image = Yii::$app->storagecontainer->addImage($v['id'], 0);
                    
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
            $files[$k]['file_data'] = Yii::$app->storagecontainer->getFile($v['id']);
        }
    
        return $files;
    }
    
    // folder helper
    
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
    
    /**
     * delete folder, all subfolders and all included files.
     *
     * 1. search another folders with matching parentIds and call deleteFolder on them
     * 2. get all included files and delete them
     * 3. delete folder
     *
     * @param int $folderId
     *
     * @return bool
     */
    private function helperDeleteFolder($folderId)
    {
        // find all subfolders
        $matchingChildFolders = StorageFolder::find()->where(['parent_id' => $folderId])->asArray()->all();
        foreach ($matchingChildFolders as $matchingChildFolder) {
            $this->helperDeleteFolder($matchingChildFolder['id']);
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
    
    /**
     * check if a folder is empty (without subfolders and/or files).
     *
     * @param int $folderId
     *
     * @return bool
     */
    private function helperIsEmptyFolder($folderId)
    {
        if (!empty($this->getSubFolders($folderId))) {
            return false;
        } else {
            return empty($this->filesAllFromFolder($folderId));
        }
    }
    
}
