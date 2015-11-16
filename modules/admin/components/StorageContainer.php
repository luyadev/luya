<?php

namespace admin\components;

use Yii;
use Exception;
use yii\db\Query;
use admin\storage\FileQuery;
use luya\helpers\FileHelper;
use yii\helpers\Inflector;
use admin\helpers\Storage;
use admin\models\StorageFile;

/**
 * Create images, files, manipulate, foreach and get details. The storage container 
 * will be the singleton similar instance containing all the loaded images and files
 * 
 * ### files
 * 
 * ```php
 * Yii::$app->storage->findFiles(['folderId' => 10]);
 * ```
 * 
 * which is equal to:
 * 
 * ```php
 * (new admin\file\Query())->where(['folder_id' => 10])->all();
 * ```
 * 
 * to add a new file into the storage system use setFile
 * 
 * 
 * 
 * 
 * ### getFile
 * 
 * ```php
 * Yii::$app->storage->getFile(5);
 * ```
 * 
 * which is equal to:
 * 
 * ```php
 * (new admin\file\Query())->where(['id' => 10])->one();
 * ```
 * 
 * @property string $httpPath Get the http path to the storage folder.
 * @property string $serverPath Get the server path (for php) to the storage folder.
 * @property array $filesArray An array containing all files
 * @property array $imagesArray An array containg all images
 * @property array $foldersArray An array containing all folders
 * 
 * @author nadar
 */
class StorageContainer extends \yii\base\Component {
    
    public $request = null;
    
    private $_httpPath = null;
    
    private $_serverPath = null;
    
    private $_filesArray = null;
    
    private $_imagesArray = null;
    
    private $_foldersArray = null;
    
    public function __construct(\luya\web\Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }
    
    public function getHttpPath()
    {
        if ($this->_httpPath === null) {
            $this->_httpPath = $this->request->baseUrl . '/storage';
        }
        
        return $this->_httpPath;
    }
    
    public function getServerPath()
    {
        if ($this->_serverPath === null) {
            $this->_serverPath = Yii::getAlias('@webroot') . '/storage';
        }
        
        return $this->_serverPath;
    }
    
    public function getFilesArray()
    {
        if ($this->_filesArray === null) {
            $this->_filesArray = (new Query())->from('admin_storage_file')->indexBy('id')->all();
        }
        
        return $this->_filesArray;
    }
    
    public function getFilesArrayItem($fileId)
    {
        return (isset($this->filesArray[$fileId])) ? $this->filesArray[$fileId] : false;
    }
    
    public function getImagesArray()
    {
        if ($this->_imagesArray === null) {
            $this->_imagesArray = (new Query())->from('admin_storage_image')->indexBy('id')->all();
        }
        
        return $this->_imagesArray;
    }
    
    public function getImagesArrayItem($imageId)
    {
        return (isset($this->imagesArray[$imageId])) ? $this->imagesArray[$imageId] : false;
    }
    
    public function getFoldersArray()
    {
        if ($this->_foldersArray === null) {
            $this->_foldersArray = (new Query())->from('admin_storage_folder')->indexBy('id')->all();
        }
        
        return $this->_foldersArray;
    }
    
    public function getFoldersArrayItem($folderId)
    {
        return (isset($this->foldersArray[$folderId])) ? $this->foldersArray[$folderId] : false;
    }
    
    public function findFiles(array $args)
    {
        return (new FileQuery())->where($args)->all();
    }
    
    public function getFile($fileId)
    {
        return (new FileQuery())->findOne($fileId);
    }
    
    /**
     * @todo its a copy from the old colde, refactor code
     * @param string $fileSource
     * @param string $fileName
     * @param int $folderId
     */
    public function addFile($fileSource, $fileName, $folderId = 0)
    {
        if (empty($fileSource) || empty($fileName)) {
            throw new Exception("Unable to create file where file source and/or file name is empty.");
        }
        
        $fileInfo = FileHelper::getFileInfo($fileName);
        
        $baseName = Inflector::slug($fileInfo->name, '-');
        
        $fileHashName = Storage::createFileHash($fileName);
        
        $fileHash = FileHelper::getFileHash($fileSource);
        
        $mimeType = FileHelper::getMimeType($fileSource);
        
        $newName = implode([$baseName.'_'.$fileHashName, $fileInfo->extension], '.');
        
        $savePath = $this->serverPath . '/' . $newName;
        
        if (is_uploaded_file($fileSource)) {
            if (!@move_uploaded_file($fileSource, $savePath)) {
                throw new Exception("error while moving uploaded file from $sourceFile to $savePath");
            }
        } else {
            if (!@copy($fileSource, $savePath)) {
                throw new Exception("error while copy file from $sourceFile to $savePath.");
            }
        }
        
        $model = new StorageFile();
        $model->setAttributes([
            'name_original' => $fileName,
            'name_new' => $baseName,
            'name_new_compound' => $newName,
            'mime_type' => $mimeType,
            'extension' => strtolower($fileInfo->extension),
            'folder_id' => (int) $folderId,
            'hash_file' => $fileHash,
            'hash_name' => $fileHashName,
            'is_hidden' => 0,
            'file_size' => @filesize($savePath),
        ]);
        
        if ($model->validate()) {
            if ($model->save()) {
                $this->_filesArray[$model->id] = $model->toArray();
                return $this->getFile($model->id);
            }
        }
        
        return false;
    }
    
    public function findImage()
    {
        
    }
    
    public function getImage($imageId) {} // new admin\image\Item();
    
    public function addImage($fileId, $filterId) {}
    
    public function getFolders() {} // new admin\folder\Query();
    
    public function addFolder($folderName, $parentFolderId) {}
}