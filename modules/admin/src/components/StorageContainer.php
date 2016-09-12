<?php

namespace luya\admin\components;

use Yii;
use yii\db\Query;
use yii\helpers\Inflector;
use yii\base\Component;
use luya\Exception;
use luya\helpers\FileHelper;
use luya\helpers\Url;
use luya\admin\helpers\Storage;
use luya\admin\models\StorageFile;
use luya\admin\models\StorageImage;
use luya\admin\models\StorageFilter;
use luya\admin\models\StorageFolder;
use luya\traits\CacheableTrait;
use luya\web\Request;

/**
 * Storage Container for reading, saving and holding files.
 *
 * Create images, files, manipulate, foreach and get details. The storage container
 * will be the singleton similar instance containing all the loaded images and files.
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
 * (new \luyaadmin\file\Query())->where(['folder_id' => 10])->all();
 * ```
 *
 * to add a new file into the storage system use setFile
 *
 * use Yii::$app->storage->addFile() to add a new file
 *
 * get a single file an return file object
 *
 * ```php
 * Yii::$app->storage->getFile(5);
 * ```
 *
 * which is equal to:
 *
 * ```php
 * (new \luyaadmin\file\Query())->where(['id' => 10])->one();
 * ```
 *
 * or
 *
 * ```php
 * (new \luyaadmin\file\Query())->findOne(10);
 * ```
 *
 * ### images
 *
 * ### filters
 *
 * ### folders
 *
 * @property string $httpPath Get the http path to the storage folder.
 * @property string $absoluteHttpPath Get the absolute http path to the storage folder.
 * @property string $serverPath Get the server path (for php) to the storage folder.
 * @property array $filesArray An array containing all files
 * @property array $imagesArray An array containg all images
 * @property array $foldersArray An array containing all folders
 * @property array $filtersArray An array with all filters
 *
 * @author Basil Suter <basil@nadar.io>
 */
class StorageContainer extends Component
{
    use CacheableTrait;
    
    /**
     * @var \luya\web\Request Request object resolved from DI.
     */
    public $request = null;
    
    public $fileCacheKey = 'storageFileCacheKey';
    
    public $imageCacheKey = 'storageImageCacheKey';
    
    public $folderCacheKey = 'storageFolderCacheKey';
    
    public $filterCacheKey = 'storageFilterCacheKey';
    
    /**
     * @var boolean When enabled the storage component will try to recreated missing images when `getSource()` of an
     * image is called but the `getFileExists()` does return false, which means that the source file has been deleted.
     * So in those cases the storage component will automatiaccly try to recreated this image based on the filterId and
     * fileId.
     */
    public $autoFixMissingImageSources = true;
    
    /**
     * Consturctor resolveds Request component from DI container
     *
     * @param \luya\web\Request $request
     * @param array $config
     */
    public function __construct(Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }
    
    private $_httpPath = null;
    
    /**
     * Setter for the http path in order to read online storage files.
     *
     * Sometimes you want to set the http directory of where the files are display in the frontend to read from another
     * server. For example you have a prod and a preprod sytem and when deploying the preprod system the database will
     * be copied into the preprod system from prod. Now all the files are located on the prod system and you will have
     * broke image/file links. To generate the image/file links you can now override the httpPath in your configuration
     * to read all the files from the prod server. For example add this in the `components` section of your config:
     *
     * ```php
     * 'storage' => [
     *     'class' => 'admin\components\StorageContainer',
     *     'httpPath' => 'http://prod.example.com/storage',
     * ]
     * ```
     *
     * @param string $path The location of your storage folder without trailing slash. E.g `http://prod.example.com/storage`
     */
    public function setHttpPath($path)
    {
        $this->_httpPath = $path;
    }
    
    /**
     * Get the base path to the storage directory.
     *
     * @return string Get the relative http path to the storage folder if nothing is provided by the setter method `setHttpPath()`.
     */
    public function getHttpPath()
    {
        if ($this->_httpPath === null) {
            $this->_httpPath = $this->request->baseUrl . '/storage';
        }
        
        return $this->_httpPath;
    }
    
    private $_absoluteHttpPath = null;
    
    /**
     * Setter fro the absolute http path in order to read from another storage source.
     *
     * Sometimes you want to set the http directory of where the files are display in the frontend to read from another
     * server. For example you have a prod and a preprod sytem and when deploying the preprod system the database will
     * be copied into the preprod system from prod. Now all the files are located on the prod system and you will have
     * broke image/file links. To generate the image/file links you can now override the httpPath in your configuration
     * to read all the files from the prod server. For example add this in the `components` section of your config:
     *
     * ```php
     * 'storage' => [
     *     'class' => 'admin\components\StorageContainer',
     *     'absoluteHttpPath' => 'http://prod.example.com/storage',
     * ]
     * ```
     *
     * @param string $path The absolute location of your storage folder without trailing slash. E.g `http://prod.example.com/storage`
     */
    public function setAbsoluteHttpPath($path)
    {
        $this->_absoluteHttpPath = $path;
    }
    
    /**
     * Get the base absolute base path to the storage direcotry
     *
     * @return string Get the absolute http path to the storage folder if nothing is provided by the setter method `setAbsoluteHttpPath()`.
     * @since 1.0.0-beta7
     */
    public function getAbsoluteHttpPath()
    {
        if ($this->_absoluteHttpPath === null) {
            $this->_absoluteHttpPath = Url::base(true) . '/storage';
        }

        return $this->_absoluteHttpPath;
    }
    
    private $_serverPath = null;
    
    /**
     * Get the internal server path to the storage folder
     *
     * @return string
     */
    public function getServerPath()
    {
        if ($this->_serverPath === null) {
            $this->_serverPath = Yii::getAlias('@webroot') . '/storage';
        }
        
        return $this->_serverPath;
    }
    
    private $_filesArray = null;
    
    /**
     *
     * @return NULL|mixed|boolean
     */
    public function getFilesArray()
    {
        if ($this->_filesArray === null) {
            $this->_filesArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_file')->select(['id', 'is_hidden', 'is_deleted', 'folder_id', 'name_original', 'name_new', 'name_new_compound', 'mime_type', 'extension', 'hash_name', 'upload_timestamp', 'file_size', 'upload_user_id', 'caption'])->indexBy('id'), $this->fileCacheKey);
        }
        
        return $this->_filesArray;
    }
    
    /**
     *
     * @param unknown $fileId
     * @return boolean|mixed
     */
    public function getFilesArrayItem($fileId)
    {
        return (isset($this->filesArray[$fileId])) ? $this->filesArray[$fileId] : false;
    }
    
    private $_imagesArray = null;
    
    /**
     *
     * @return NULL|mixed|boolean
     */
    public function getImagesArray()
    {
        if ($this->_imagesArray === null) {
            $this->_imagesArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_image')->select(['id', 'file_id', 'filter_id', 'resolution_width', 'resolution_height'])->indexBy('id'), $this->imageCacheKey);
        }
        
        return $this->_imagesArray;
    }
    
    /**
     *
     * @param unknown $imageId
     * @return boolean|mixed
     */
    public function getImagesArrayItem($imageId)
    {
        return (isset($this->imagesArray[$imageId])) ? $this->imagesArray[$imageId] : false;
    }
    
    /**
     * Find multiples files with an \luyaadmin\file\Query all
     *
     * @param array $args
     */
    public function findFiles(array $args = [])
    {
        return (new \luya\admin\file\Query())->where($args)->all();
    }
    
    /**
     * Find a single file with an \luyaadmin\file\Query one
     * @param array $args
     */
    public function findFile(array $args = [])
    {
        return (new \luya\admin\file\Query())->where($args)->one();
    }
    
    /**
     *
     * @param unknown $fileId
     * @return \admin\storage\admin\storage\QueryTrait|\admin\storage\Object
     */
    public function getFile($fileId)
    {
        return (new \luya\admin\file\Query())->findOne($fileId);
    }
    
    /**
     * Add a new file based on the source to the file
     *
     * @param string $fileSource Path to the file source where the file should be created from
     * @param string $fileName The name of this file (must contain data type suffix).
     * @param int $folderId The id of the folder where the file should be sorted in
     * @param boolean $isHidden Should the file visible in the filemanager
     * @return boolean|\admin\file\Item|\Exception
     */
    public function addFile($fileSource, $fileName, $folderId = 0, $isHidden = false)
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
                throw new Exception("error while moving uploaded file from $fileSource to $savePath");
            }
        } else {
            if (!@copy($fileSource, $savePath)) {
                throw new Exception("error while copy file from $fileSource to $savePath.");
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
            'is_hidden' => ($isHidden) ? 1 : 0,
            'is_deleted' => 0,
            'file_size' => @filesize($savePath),
            'caption' => null,
        ]);
        
        if ($model->validate()) {
            if ($model->save()) {
                $this->deleteHasCache($this->fileCacheKey);
                $this->_filesArray[$model->id] = $model->toArray();
                return $this->getFile($model->id);
            }
        }
        
        return false;
    }
    
    /**
     *
     * @param array $args
     */
    public function findImages(array $args = [])
    {
        return (new \luya\admin\image\Query())->where($args)->all();
    }
    
    /**
     *
     * @param array $args
     */
    public function findImage(array $args = [])
    {
        return (new \luya\admin\image\Query())->where($args)->one();
    }
    
    /**
     *
     * @param unknown $imageId
     * @return \luya\admin\storage\admin\storage\QueryTrait|\luya\admin\storage\Object
     */
    public function getImage($imageId)
    {
        return (new \luya\admin\image\Query())->findOne($imageId);
    }
    
    /**
     * Add a new image based on an existing file information.
     *
     * @param integer $fileId The id of the file where image should be created from.
     * @param integer $filterId The id of the filter which should be applied to, if filter is 0, no filter will be added. Filter can new also be the string name of the filter like `tiny-crop`.
     * @param boolean $throwException Whether the addImage should throw an exception or just return boolean
     * @return boolean|\admin\image\Item|\Exception
     */
    public function addImage($fileId, $filterId = 0, $throwException = false)
    {
        try {
            // if the filterId is provded as a string the filter will be looked up by its name in the get filters array list.
            if (is_string($filterId) && !is_numeric($filterId)) {
                $filterLookup = $this->getFiltersArrayItem($filterId);
                if (!$filterLookup) {
                    throw new Exception("The provided filter name " . $filterId . " does not exist.");
                }
                $filterId = $filterLookup['id'];
            }
            
            $query = (new \luya\admin\image\Query())->where(['file_id' => $fileId, 'filter_id' => $filterId])->one();
            
            if ($query && $query->fileExists) {
                return $query;
            }
            
            $fileQuery = $this->getFile($fileId);
            
            if (!$fileQuery || !$fileQuery->fileExists) {
                throw new Exception("Unable to create image, cause the base file does not exist.");
            }
            
            $fileName = $filterId.'_'.$fileQuery->systemFileName;
            $fileSavePath = $this->serverPath . '/' . $fileName;
            
            if (empty($filterId)) {
                $save = @copy($fileQuery->serverSource, $fileSavePath);
            } else {
                $model = StorageFilter::find()->where(['id' => $filterId])->one();
                
                if (!$model) {
                    throw new Exception("Could not find the provided filter id '$filterId'.");
                }
                
                if (!$model->applyFilterChain($fileQuery, $fileSavePath)) {
                    throw new Exception("Unable to create and save image '".$fileSavePath."'.");
                }
            }
            
            $resolution = Storage::getImageResolution($fileSavePath);
            
            // ensure the existing of the model
            $model = StorageImage::find()->where(['file_id' => $fileId, 'filter_id' => $filterId])->one();
            
            if ($model) {
                $model->updateAttributes([
                    'resolution_width' => $resolution['width'],
                    'resolution_height' => $resolution['height'],
                ]);
            } else {
                $model = new StorageImage();
                $model->setAttributes([
                    'file_id' => $fileId,
                    'filter_id' => $filterId,
                    'resolution_width' => $resolution['width'],
                    'resolution_height' => $resolution['height'],
                ]);
                
                if (!$model->save()) {
                    throw new Exception("Unable to save storage image, fatal database exception.");
                }
            }
            
            $this->_imagesArray[$model->id] = $model->toArray();
            $this->deleteHasCache($this->imageCacheKey);
            return $this->getImage($model->id);
        } catch (\Exception $err) {
            if ($throwException) {
                throw new Exception("add image exception: " . $err->getMessage(), 0, $err);
            }
        }
        
        return false;
    }
    
    private $_foldersArray = null;
    
    /**
     *
     * @return NULL|mixed|boolean
     */
    public function getFoldersArray()
    {
        if ($this->_foldersArray === null) {
            $this->_foldersArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_folder')->select(['id', 'name', 'parent_id', 'timestamp_create'])->where(['is_deleted' => 0])->orderBy(['name' => 'ASC'])->indexBy('id'), $this->folderCacheKey);
        }
        
        return $this->_foldersArray;
    }
    
    /**
     *
     * @param unknown $folderId
     * @return boolean|mixed
     */
    public function getFoldersArrayItem($folderId)
    {
        return (isset($this->foldersArray[$folderId])) ? $this->foldersArray[$folderId] : false;
    }
    
    /**
     *
     * @param array $args
     */
    public function findFolders(array $args = [])
    {
        return (new \luya\admin\folder\Query())->where($args)->all();
    }
    
    /**
     *
     * @param array $args
     */
    public function findFolder(array $args = [])
    {
        return (new \luya\admin\folder\Query())->where($args)->one();
    }
    
    /**
     *
     * @param unknown $folderId
     */
    public function getFolder($folderId)
    {
        return (new \luya\admin\folder\Query())->where(['id' => $folderId])->one();
    }
    
    /**
     * Add new folder
     *
     * @param unknown $folderName
     * @param number $parentFolderId
     * @return fals|folder Id
     */
    public function addFolder($folderName, $parentFolderId = 0)
    {
        $model = new StorageFolder();
        $model->name = $folderName;
        $model->parent_id = $parentFolderId;
        $model->timestamp_create = time();
        $this->deleteHasCache($this->folderCacheKey);
        if ($model->save(false)) {
            return $model->id;
        }
        
        return false;
    }
    
    private $_filtersArray = null;
    
    /**
     *
     * @return NULL|mixed|boolean
     */
    public function getFiltersArray()
    {
        if ($this->_filtersArray === null) {
            $this->_filtersArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_filter')->select(['id', 'identifier', 'name'])->indexBy('identifier'), $this->filterCacheKey);
        }
        
        return $this->_filtersArray;
    }
    
    /**
     *
     * @param unknown $filterIdentifier
     * @return boolean|mixed
     */
    public function getFiltersArrayItem($filterIdentifier)
    {
        return (isset($this->filtersArray[$filterIdentifier])) ? $this->filtersArray[$filterIdentifier] : false;
    }
    
    protected function getQueryCacheHelper(\yii\db\Query $query, $key)
    {
        $data = $this->getHasCache($key);
        
        if ($data === false) {
            $data = $query->all();
            $this->setHasCache($key, $data);
        }
        
        return $data;
    }
    
    /**
     * Will force to refresh all container arrays and clean up the cache
     *
     * @since 1.0.0-beta5
     */
    public function flushArrays()
    {
        $this->_filesArray = null;
        $this->_imagesArray = null;
        $this->_foldersArray = null;
        $this->_filtersArray = null;
        $this->deleteHasCache($this->fileCacheKey);
        $this->deleteHasCache($this->imageCacheKey);
        $this->deleteHasCache($this->folderCacheKey);
        $this->deleteHasCache($this->filterCacheKey);
    }
    
    /**
     * This method allwos you to generate all thumbnails for the file manager, you can trigger this process when
     * importing or creating several images at once, so the user does not have to create the thumbnails
     *
     * @return void
     * @since 1.0.0-beta6
     */
    public function processThumbnails()
    {
        foreach ($this->findFiles(['is_hidden' => 0, 'is_deleted' => 0]) as $file) {
            if ($file->isImage) {
                // create tiny thumbnail
                $this->addImage($file->id, 'tiny-crop');
                $this->addImage($file->id, 'medium-thumbnail');
            }
        }
        
        return true;
    }
}
