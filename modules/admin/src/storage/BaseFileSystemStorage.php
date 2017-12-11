<?php

namespace luya\admin\storage;

use Yii;
use yii\db\Query;
use yii\helpers\Inflector;
use yii\base\Component;
use luya\Exception;
use luya\helpers\FileHelper;
use luya\admin\helpers\Storage;
use luya\admin\models\StorageFile;
use luya\admin\models\StorageImage;
use luya\admin\models\StorageFilter;
use luya\admin\models\StorageFolder;
use luya\traits\CacheableTrait;
use luya\web\Request;
use luya\admin\filters\TinyCrop;
use luya\admin\filters\MediumThumbnail;

/**
 * Storage Container for reading, saving and holding files.
 *
 * Create images, files, manipulate, foreach and get details. The storage container will be the singleton similar instance containing all the loaded images and files.
 *
 * The base storage system is implemented by filesystems:
 *
 * + {{luya\admin\filesystem\LocalStorage}} (Default system for the admin module)
 * + {{luya\admin\filesystem\S3}}
 *
 * As files, images and folders implement the same traits you can also read more about enhanced usage:
 *
 * + Querying Data with {{\luya\admin\storage\QueryTrait}}
 * + Where conditions {{\luya\admin\storage\QueryTrait::where()}}
 *
 * ## Handling Files
 *
 * First adding a new file to the Storage system using the {{\luya\admin\storage\BaseFileSystemStorage::addFile()}} method.
 *
 * ```php
 * Yii::$app->storage->addFile('/the/path/to/File.jpg', 'File.jpg', 0, 1);
 * ```
 *
 * The response of the add file method is an {{\luya\admin\file\Item}} Object.
 *
 * Get an array of files based on search parameters (When not passing any arguments all files would be returned.):
 *
 * ```php
 * Yii::$app->storage->findFiles(['is_hidden' => 0, 'is_deleted' => 0]);
 * ```
 *
 * In order to get a single file object based on its ID use:
 *
 * ```php
 * Yii::$app->storage->getFile(5);
 * ```
 *
 * To find a file based on other where arguments instead of the id use findFile:
 *
 * ```php
 * Yii::$app->storage->findFile(['name' => 'MyFile.jpg']);
 * ```
 *
 * ### Handling Images
 *
 * An image object is always based on the {{\luya\admin\file\Item}} object and a {{luya\admin\base\Filter}}. In order to add an image you already need a fileId and filterId. If the filterId is 0, it means no additional filter will be applied.
 *
 * ```php
 * Yii::$app->storage->addImage(123, 0); // create an image from file object id 123 without filter.
 * ```
 *
 * The newly created image will return a {{luya\admin\image\Item}} object.
 *
 * In order to find one image:
 *
 * ```php
 * Yii::$app->storage->findImage(['id' => 123]);
 * ```
 *
 * or find one image by its ID:
 *
 * ```php
 * Yii::$app->storage->getImage(123);
 * ```
 *
 * To get an array of images based on where conditions use:
 *
 * ```php
 * Yii::$app->storage->findImages(['file_id' => 1, 'filter_id' => 0]);
 * ```
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
 * @since 1.0.0
 */
abstract class BaseFileSystemStorage extends Component
{
    use CacheableTrait;
    
    /**
     * Get the base path to the storage directory.
     *
     * @return string Get the relative http path to the storage folder if nothing is provided by the setter method `setHttpPath()`.
     */
    abstract public function getHttpPath();
    
    /**
     * Get the base absolute base path to the storage directory.
     *
     * @return string Get the absolute http path to the storage folder if nothing is provided by the setter method `setAbsoluteHttpPath()`.
     */
    abstract public function getAbsoluteHttpPath();
    
    /**
     * Get the internal server path to the storage folder.
     *
     * Default path is `@webroot/storage`.
     *
     * @return string Get the path on the server to the storage folder based @webroot alias.
     */
    abstract public function getServerPath();
    
    /**
     * Save the given file source as a new file with the given fileName on the filesystem.
     *
     * @param string $source The absolute file source path and filename, like `/tmp/upload/myfile.jpg`.
     * @param string $fileName The new of the file on the file system like `MyNewFile.jpg`.
     * @return boolean Whether the file has been stored or not.
     */
    abstract public function fileSystemSaveFile($source, $fileName);
    
    /**
     * Replace an existing file source with a new one on the filesystem.
     *
     * @param string $oldSource The absolute file source path and filename, like `/tmp/upload/myfile.jpg`.
     * @param string $newSource The absolute file source path and filename, like `/tmp/upload/myfile.jpg`.
     * @return boolean Whether the file has replaced stored or not.
     */
    abstract public function fileSystemReplaceFile($oldSource, $newSource);
    
    /**
     * Delete a given file source on the filesystem.
     * @param string $source The absolute file source path and filename, like `/tmp/upload/myfile.jpg`.
     * @return boolean Whether the file has been deleted or not.
     */
    abstract public function fileSystemDeleteFile($source);
    
    /**
     * @var string File cache key.
     */
    const CACHE_KEY_FILE = 'storage_fileCacheKey';
    
    /**
     * @var string Image cache key.
     */
    const CACHE_KEY_IMAGE = 'storage_imageCacheKey';
    
    /**
     * @var string Folder cache key.
     */
    const CACHE_KEY_FOLDER = 'storage_folderCacheKey';
    
    /**
     * @var string Filter cache key.
     */
    const CACHE_KEY_FILTER = 'storage_filterCacheKey';
    
    /**
     * @var array The mime types which will be rejected.
     */
    public $dangerousMimeTypes = [
        'application/x-msdownload',
        'application/x-msdos-program',
        'application/x-msdos-windows',
        'application/x-download',
        'application/bat',
        'application/x-bat',
        'application/com',
        'application/x-com',
        'application/exe',
        'application/x-exe',
        'application/x-winexe',
        'application/x-winhlp',
        'application/x-winhelp',
        'application/x-javascript',
        'application/hta',
        'application/x-ms-shortcut',
        'application/octet-stream',
        'vms/exe',
        'text/javascript',
        'text/scriptlet',
        'text/x-php',
        'text/plain',
        'application/x-spss',
    ];

    /**
     * @var array The extension which will be rejected.
     */
    public $dangerousExtensions = [
        'html', 'php', 'phtml', 'php3', 'exe', 'bat', 'js',
    ];

    /**
     * @var boolean Whether secure file upload is enabled or not. If enabled dangerous mime types and extensions will
     * be rejected and the file mime type needs to be verified by phps `fileinfo` extension.
     */
    public $secureFileUpload = true;

    /**
     * @var \luya\web\Request Request object resolved by the Dependency Injector.
     */
    public $request;

    /**
     * @var boolean When enabled the storage component will try to recreated missing images when {{luya\admin\image\Item::getSource()}} of an
     * image is called but the `getFileExists()` does return false, which means that the source file has been deleted.
     * So in those cases the storage component will automatiaccly try to recreated this image based on the filterId and
     * fileId.
     */
    public $autoFixMissingImageSources = true;

    /**
     * Consturctor resolveds Request component from DI container
     *
     * @param \luya\web\Request $request The request component class resolved by the Dependency Injector.
     * @param array $config
     */
    public function __construct(Request $request, array $config = [])
    {
        $this->request = $request;
        parent::__construct($config);
    }

    private $_filesArray;

    /**
     * Get all storage files as an array from database.
     *
     * This method is used to retrieve all files from the database and indexed by file key.
     *
     * @return array An array with all storage files indexed by the file id.
     */
    public function getFilesArray()
    {
        if ($this->_filesArray === null) {
            $this->_filesArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_file')->select(['id', 'is_hidden', 'is_deleted', 'folder_id', 'name_original', 'name_new', 'name_new_compound', 'mime_type', 'extension', 'hash_name', 'hash_file', 'upload_timestamp', 'file_size', 'upload_user_id', 'caption'])->indexBy('id'), self::CACHE_KEY_FILE);
        }

        return $this->_filesArray;
    }
    
    /**
     * Setter method for fiels array.
     *
     * This is mainly used when working with unit tests.
     *
     * @param array $files
     */
    public function setFilesArray(array $files)
    {
        $this->_filesArray = $files;
    }

    /**
     * Get a single file by file id from the files array.
     *
     * @param integer $fileId The file id to find.
     * @return boolean|array The file array or false if not found.
     */
    public function getFilesArrayItem($fileId)
    {
        return (isset($this->filesArray[$fileId])) ? $this->filesArray[$fileId] : false;
    }

    private $_imagesArray;

    /**
     * Get all storage images as an array from database.
     *
     * This method is used to retrieve all images from the database and indexed by image key.
     *
     * @return array An array with all storage images indexed by the image id.
     */
    public function getImagesArray()
    {
        if ($this->_imagesArray === null) {
            $this->_imagesArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_image')->select(['id', 'file_id', 'filter_id', 'resolution_width', 'resolution_height'])->indexBy('id'), self::CACHE_KEY_IMAGE);
        }

        return $this->_imagesArray;
    }

    /**
     * Setter method for images array.
     *
     * This is mainly used when working with unit tests.
     *
     * @param array $images
     */
    public function setImagesArray(array $images)
    {
        $this->_imagesArray = $images;
    }
    
    /**
     * Get a single image by image id from the files array.
     *
     * @param integer $imageId The image id to find.
     * @return boolean|array The image array or false if not found.
     */
    public function getImagesArrayItem($imageId)
    {
        return (isset($this->imagesArray[$imageId])) ? $this->imagesArray[$imageId] : false;
    }

    /**
     * Get an array with all files based on a where condition.
     *
     * This method returns an array with files matching there $args array condition. If no argument is provided all files will be returned.
     *
     * See {{\luya\admin\storage\QueryTrait::where}} for condition informations.
     *
     * @param array $args An array with conditions to match e.g. `['is_hidden' => 1, 'is_deleted' => 0]`.
     * @return \luya\admin\file\Iterator An iterator object containing all files found for the condition provided.
     */
    public function findFiles(array $args = [])
    {
        return (new \luya\admin\file\Query())->where($args)->all();
    }

    /**
     * Get a single file based on a where condition.
     *
     * This method returns a single file matching the where condition, if the multiple results match the condition the first one will be picked.
     *
     * See {{\luya\admin\storage\QueryTrait::where}} for condition informations.
     *
     * @param array $args An array with conditions to match e.g. `['is_hidden' => 1, 'is_deleted' => 0]`.
     * @return \luya\admin\file\Item The file item object.
     */
    public function findFile(array $args)
    {
        return (new \luya\admin\file\Query())->where($args)->one();
    }

    /**
     * Get a single file based on the the ID.
     *
     * If not found false is returned.
     *
     * @param integer $fileId The requested storage file id.
     * @return \luya\admin\file\Item|boolean The file object or false if not found.
     */
    public function getFile($fileId)
    {
        return (new \luya\admin\file\Query())->findOne($fileId);
    }

    /**
     * Ensure a file uploads and return relevant file infos.
     *
     * @param string $fileSource The file on the server ($_FILES['tmp'])
     * @param string $fileName Original upload name of the file ($_FILES['name'])
     * @throws Exception
     * @return array Returns an array with the following KeywordPatch
     * + fileInfo:
     * + mimeType:
     * + fileName:
     * + secureFileName: The file name with all insecure chars removed
     * + fileSource:
     * + extension: jpg, png, etc.
     * + hashName: a short hash name for the given file, not the md5 sum.
     */
    public function ensureFileUpload($fileSource, $fileName)
    {
        if (empty($fileSource) || empty($fileName)) {
            throw new Exception("Filename and source can not be empty.");
        }

        if ($fileName == 'blob') {
            $ext = FileHelper::getExtensionsByMimeType(FileHelper::getMimeType($fileSource));
            $fileName = 'paste-'.date("Y-m-d-H-i").'.'.$ext[0];
        }

        $fileInfo = FileHelper::getFileInfo($fileName);

        $mimeType = FileHelper::getMimeType($fileSource, null, !$this->secureFileUpload);

        if (empty($mimeType)) {
            if ($this->secureFileUpload) {
                throw new Exception("Unable to find mimeType for the given file, make sure the php extension 'fileinfo' is installed.");
            } else {
                // this is dangerous and not recommend
                $mimeType = FileHelper::getMimeType($fileName);
            }
        }

        $extensionByMimeType = FileHelper::getExtensionsByMimeType($mimeType);
         
        if (empty($extensionByMimeType)) {
            throw new Exception("Unable to find extension for type $mimeType or it contains insecure data.");
        }
         
        if (!in_array($fileInfo->extension, $extensionByMimeType)) {
            throw new Exception("The given file extension {$fileInfo->extension} is not matching its mime type.");
        }
         
        foreach ($extensionByMimeType as $extension) {
            if (in_array($extension, $this->dangerousExtensions)) {
                throw new Exception("This file extension seems to be dangerous and can not be stored.");
            }
        }

        if (in_array($mimeType, $this->dangerousMimeTypes)) {
            throw new Exception("This file type seems to be dangerous and can not be stored.");
        }

        return [
            'fileInfo' => $fileInfo,
            'mimeType' => $mimeType,
            'fileName' => $fileName,
            'secureFileName' => Inflector::slug(str_replace('_', '-', $fileInfo->name), '-'),
            'fileSource' => $fileSource,
            'fileSize' => filesize($fileSource),
            'extension' => $fileInfo->extension,
            'hashName' => FileHelper::hashName($fileName),
        ];
    }

    /**
     * Add a new file based on the source to the storage system.
     *
     * When using the $_FILES array you can also make usage of the file helper methods:
     *
     * + {{luya\admin\helpers\Storage::uploadFromFiles}}
     * + {{luya\admin\helpers\Storage::uploadFromFileArray}}
     *
     * When not using the $_FILES array:
     *
     * ```php
     * Yii::$app->storage->addFile('/the/path/to/File.jpg', 'File.jpg', 0, 1);
     * ```
     *
     * @param string $fileSource Path to the file source where the file should be created from
     * @param string $fileName The name of this file (must contain data type suffix).
     * @param integer $folderId The id of the folder where the file should be stored in.
     * @param boolean $isHidden Should the file visible in the filemanager or not.
     * @return bool|\luya\admin\file\Item|Exception Returns the item object, if an error happens an exception is thrown.
     * @throws Exception
     */
    public function addFile($fileSource, $fileName, $folderId = 0, $isHidden = false)
    {
        $fileData = $this->ensureFileUpload($fileSource, $fileName);

        $fileHash = FileHelper::md5sum($fileSource);

        $newName = implode([$fileData['secureFileName'].'_'.$fileData['hashName'], $fileData['extension']], '.');

        if (!$this->fileSystemSaveFile($fileSource, $newName)) {
            return false;
        }

        $model = new StorageFile();
        $model->setAttributes([
            'name_original' => $fileName,
            'name_new' => $fileData['secureFileName'],
            'name_new_compound' => $newName,
            'mime_type' => $fileData['mimeType'],
            'extension' => $fileData['extension'],
            'folder_id' => (int) $folderId,
            'hash_file' => $fileHash,
            'hash_name' => $fileData['hashName'],
            'is_hidden' => $isHidden ? true : false,
            'is_deleted' => false,
            'file_size' => $fileData['fileSize'],
            'caption' => null,
        ]);

        if ($model->validate()) {
            if ($model->save()) {
                $this->deleteHasCache(self::CACHE_KEY_FILE);
                $this->_filesArray[$model->id] = $model->toArray();
                return $this->getFile($model->id);
            }
        }
        return false;
    }

    /**
     * Get an array with all images based on a where condition.
     *
     * This method returns an array with images matching there $args array condition. If no argument is provided all images will be returned.
     *
     * See {{\luya\admin\storage\QueryTrait::where()}} for condition informations.
     *
     * @param array $args An array with conditions to match e.g. `['is_hidden' => 1, 'is_deleted' => 0]`.
     * @return \luya\admin\image\Iterator An iterator object containing all image found for the condition provided.
     */
    public function findImages(array $args = [])
    {
        return (new \luya\admin\image\Query())->where($args)->all();
    }

    /**
     * Get a single image based on a where condition.
     *
     * This method returns a single image matching the where condition, if the multiple results match the condition the first one will be picked.
     *
     * See {{\luya\admin\storage\QueryTrait::where()}} for condition informations.
     *
     * @param array $args An array with conditions to match e.g. `['is_hidden' => 1, 'is_deleted' => 0]`.
     * @return \luya\admin\image\Item The file item object.
     */
    public function findImage(array $args = [])
    {
        return (new \luya\admin\image\Query())->where($args)->one();
    }

    /**
     * Get a single image based on the the ID.
     *
     * If not found false is returned.
     *
     * @param integer $imageId The requested storage image id.
     * @return \luya\admin\image\Item|boolean The image object or false if not found.
     */
    public function getImage($imageId)
    {
        return (new \luya\admin\image\Query())->findOne($imageId);
    }

    /**
     * Add a new image based an existing file Id.
     *
     * The storage system uses the same file base, for images and files. The difference between a file and an image is the filter which is applied.
     *
     * Only files of the type image can be used (or added) as an image.
     *
     * An image object is always based on the {{\luya\admin\file\Item}} object and a {{luya\admin\base\Filter}}.
     *
     * ```php
     * Yii::$app->storage->addImage(123, 0); // create an image from file object id 123 without filter.
     * ```
     *
     * @param integer $fileId The id of the file where image should be created from.
     * @param integer $filterId The id of the filter which should be applied to, if filter is 0, no filter will be added. Filter can new also be the string name of the filter like `tiny-crop`.
     * @param boolean $throwException Whether the addImage should throw an exception or just return boolean
     * @return bool|\luya\admin\image\Item|Exception Returns the item object, if an error happens and $throwException is off `false` is returned otherwhise an exception is thrown.
     * @throws \Exception
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
                if ($fileQuery !== false) {
                    throw new Exception("Unable to create image, the base file server source '{$fileQuery->serverSource}' does not exist.");
                }

                throw new Exception("Unable to find the file with id '{$fileId}', image can not be created.");
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
            $this->deleteHasCache(self::CACHE_KEY_IMAGE);

            return $this->getImage($model->id);
        } catch (\Exception $err) {
            if ($throwException) {
                throw $err;
            }
        }

        return false;
    }

    private $_foldersArray;

    /**
     * Get all storage folders as an array from database.
     *
     * This method is used to retrieve all folders from the database and indexed by folder key.
     *
     * @return array An array with all storage folders indexed by the folder id.
     */
    public function getFoldersArray()
    {
        if ($this->_foldersArray === null) {
            $this->_foldersArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_folder')->select(['id', 'name', 'parent_id', 'timestamp_create'])->where(['is_deleted' => false])->orderBy(['name' => 'ASC'])->indexBy('id'), self::CACHE_KEY_FOLDER);
        }

        return $this->_foldersArray;
    }

    /**
     * Get a single folder by folder id from the folders array.
     *
     * @param integer $folderId The folder id to find.
     * @return boolean|array The folder array or false if not found.
     */
    public function getFoldersArrayItem($folderId)
    {
        return (isset($this->foldersArray[$folderId])) ? $this->foldersArray[$folderId] : false;
    }

    /**
     * Get an array with all folders based on a where condition.
     *
     * If no argument is provided all images will be returned.
     *
     * See {{\luya\admin\storage\QueryTrait::where()}} for condition informations.
     *
     * @param array $args An array with conditions to match e.g. `['is_hidden' => 1, 'is_deleted' => 0]`.
     * @return \luya\admin\folder\Iterator An iterator object containing all image found for the condition provided.
     */
    public function findFolders(array $args = [])
    {
        return (new \luya\admin\folder\Query())->where($args)->all();
    }

    /**
     * Get a single folder based on a where condition.
     *
     * This method returns a single fpöder matching the where condition, if the multiple results match the condition the first one will be picked.
     *
     * See {{\luya\admin\storage\QueryTrait::where()}} for condition informations.
     *
     * @param array $args An array with conditions to match e.g. `['is_hidden' => 1, 'is_deleted' => 0]`.
     * @return \luya\admin\folder\Item The folder item object.
     */
    public function findFolder(array $args = [])
    {
        return (new \luya\admin\folder\Query())->where($args)->one();
    }

    /**
     * Get a single folder based on the the ID.
     *
     * If not found false is returned.
     *
     * @param integer $folderId The requested storage folder id.
     * @return \luya\admin\folder\Item|boolean The folder object or false if not found.
     */
    public function getFolder($folderId)
    {
        return (new \luya\admin\folder\Query())->where(['id' => $folderId])->one();
    }

    /**
     * Add new folder to the storage system.
     *
     * @param string $folderName The name of the new folder
     * @param integer $parentFolderId If its a subfolder the id of the parent folder must be provided.
     * @return boolean|integer Returns the folder id or false if something went wrong.
     */
    public function addFolder($folderName, $parentFolderId = 0)
    {
        $model = new StorageFolder();
        $model->name = $folderName;
        $model->parent_id = $parentFolderId;
        $model->timestamp_create = time();
        $this->deleteHasCache(self::CACHE_KEY_FOLDER);
        if ($model->save(false)) {
            return $model->id;
        }

        return false;
    }

    private $_filtersArray;

    /**
     * Get all storage filters as an array from database.
     *
     * This method is used to retrieve all filters from the database and indexed by filter identifier key.
     *
     * @return array An array with all storage filters indexed by the filter identifier.
     */
    public function getFiltersArray()
    {
        if ($this->_filtersArray === null) {
            $this->_filtersArray = $this->getQueryCacheHelper((new Query())->from('admin_storage_filter')->select(['id', 'identifier', 'name'])->indexBy('identifier'), self::CACHE_KEY_FILTER);
        }

        return $this->_filtersArray;
    }
    
    /**
     * Setter method for filters array.
     *
     * This is mainly used when working with unit tests.
     *
     * @param array $filters
     */
    public function setFiltersArray(array $filters)
    {
        $this->_filtersArray = $filters;
    }

    /**
     * Get a single filter by filter identifier from the filters array.
     *
     * @param integer $filterIdentifier The filter identifier to find use {{luya\admin\base\Filter::identifier()}} method.
     * @return boolean|array The filter array or false if not found.
     */
    public function getFiltersArrayItem($filterIdentifier)
    {
        return (isset($this->filtersArray[$filterIdentifier])) ? $this->filtersArray[$filterIdentifier] : false;
    }

    /**
     * Caching helper method.
     *
     * @param \yii\db\Query $query
     * @param string|array $key
     * @return mixed|boolean
     */
    private function getQueryCacheHelper(\yii\db\Query $query, $key)
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
     */
    public function flushArrays()
    {
        $this->_filesArray = null;
        $this->_imagesArray = null;
        $this->_foldersArray = null;
        $this->_filtersArray = null;
        $this->deleteHasCache(self::CACHE_KEY_FILE);
        $this->deleteHasCache(self::CACHE_KEY_IMAGE);
        $this->deleteHasCache(self::CACHE_KEY_FOLDER);
        $this->deleteHasCache(self::CACHE_KEY_FILTER);
    }

    /**
     * This method allwos you to generate all thumbnails for the file manager, you can trigger this process when
     * importing or creating several images at once, so the user does not have to create the thumbnails
     *
     * @return boolean
     */
    public function processThumbnails()
    {
        foreach ($this->findFiles(['is_hidden' => false, 'is_deleted' => false]) as $file) {
            if ($file->isImage) {
                // create tiny thumbnail
                $this->addImage($file->id, TinyCrop::identifier());
                $this->addImage($file->id, MediumThumbnail::identifier());
            }
        }

        // force auto fix
        $this->autoFixMissingImageSources = true;

        foreach ($this->findImages() as $image) {
            if (!empty($image->file) && !$image->file->isHidden && !$image->file->isDeleted) {
                $image->source; // which forces to recreate missing sources.
            }
        }

        return true;
    }
}
