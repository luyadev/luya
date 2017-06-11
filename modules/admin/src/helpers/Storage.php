<?php

namespace luya\admin\helpers;

use Exception;
use Yii;
use luya\admin\models\StorageFile;
use luya\admin\models\StorageImage;

/**
 * Helper class to handle remove, upload and moving of storage files.
 *
 * The class provides common functions in order to work with the Storage component. This helper method will only work
 * if the {{luya\admin\components\StorageContainer}} component is registered which is by default the case when the LUYA
 * admin module is provided.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Storage
{
    /**
     * @var array All possible error codes when uploading files with its given message and meaning.
     */
    public static $uploadErrors = [
        0 => 'There is no error, the file uploaded with success.',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        3 => 'The uploaded file was only partially uploaded.',
        4 => 'No file was uploaded.',
        6 => 'Missing a temporary folder.',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    ];
    
    /**
     * Get the upload error message from a given $_FILES error code id.
     *
     * @param integer $errorId
     * @return string
     */
    public static function getUploadErrorMessage($errorId)
    {
        return isset(self::$uploadErrors[$errorId]) ? self::$uploadErrors[$errorId] : 'unknown error';
    }

    /**
     * Create a unique file hash from the file name.
     *
     * Warning
     * Because PHP's integer type is signed many crc32 checksums will result in negative integers on 32bit platforms. On 64bit installations all crc32() results will be positive integers though.
     * So you need to use the "%u" formatter of sprintf() or printf() to get the string representation of the unsigned crc32() checksum in decimal format.
     *
     * @var string $fileName The file name which should be hashed
     * @return string
     */
    public static function createFileHash($fileName)
    {
        return sprintf('%s', hash('crc32b', uniqid($fileName, true)));
    }
    
    /**
     * Remove a file from the storage system.
     *
     * @param integer $fileId The file id to delete
     * @param boolean $cleanup If cleanup is enabled, also all images will be deleted, this is by default turned off because
     * casual you want to remove the large source file but not the images where used in several tables and situations.
     * @return boolean
     */
    public static function removeFile($fileId, $cleanup = false)
    {
        $model = StorageFile::find()->where(['id' => $fileId, 'is_deleted' => false])->one();
        if ($model) {
            if ($cleanup) {
                foreach (Yii::$app->storage->findImages(['file_id' => $fileId]) as $imageItem) {
                    StorageImage::findOne($imageItem->id)->delete();
                }
            }
            $response = $model->delete();
            Yii::$app->storage->flushArrays();
            return $response;
        }
    
        return true;
    }
    
    /**
     * Remove an image from the storage system and database.
     *
     * @param integer $imageId The corresponding imageId for the {{\luya\admin\models\StorageImage}} Model to remove.
     * @param boolean $cleanup If cleanup is enabled, all other images will be deleted. Event the {{\luya\admin\models\StorageFile}} will be removed
     * from the database and filesystem. By default cleanup is disabled and will only remove the provided $imageId itself from {{\luya\admin\models\StorageImage}}.
     * @return boolean
     */
    public static function removeImage($imageId, $cleanup = false)
    {
        Yii::$app->storage->flushArrays();
        $image = Yii::$app->storage->getImage($imageId);
        if ($cleanup && $image) {
            $fileId = $image->fileId;
            foreach (Yii::$app->storage->findImages(['file_id' => $fileId]) as $imageItem) {
                $storageImage = StorageImage::findOne($imageItem->id);
                if ($storageImage) {
                    $storageImage->delete();
                }
            }
        }
        
        $file = StorageImage::findOne($imageId);
        if ($file) {
            return $file->delete();
        }
        
        return false;
    }

    /**
     * Get the image resolution of a given file path.
     *
     * @param string $filePath
     * @param bool $throwException
     * @return array
     * @throws Exception
     */
    public static function getImageResolution($filePath, $throwException = false)
    {
        $dimensions = @getimagesize($filePath);
        
        $width = 0;
        $height = 0;
        
        if (isset($dimensions[0]) && isset($dimensions[1])) {
            $width = (int)$dimensions[0];
            $height = (int)$dimensions[1];
        } elseif ($throwException) {
            throw new Exception("Unable to determine the resoltuions of the file $filePath.");
        }
        
        return [
            'width' => $width,
            'height' => $height,
        ];
    }
    
    /**
     * Move an array of storage fileIds to another folder.
     *
     * @param array $fileIds
     * @param unknown $folderId
     */
    public static function moveFilesToFolder(array $fileIds, $folderId)
    {
        foreach ($fileIds as $fileId) {
            static::moveFileToFolder($fileId, $folderId);
        }
    }
    
    /**
     * Move a storage file to another folder.
     *
     * @param string|int $fileId
     * @param string|int $folderId
     * @return boolean
     */
    public static function moveFileToFolder($fileId, $folderId)
    {
        $file = StorageFile::findOne($fileId);
        
        if ($file) {
            $file->updateAttributes(['folder_id' => $folderId]);
            Yii::$app->storage->flushArrays();
            return true;
        }
        
        return false;
    }
    
    /**
     * Replace the source of a file on the webeserver based on new and old source path informations.
     *
     * The replaced file will have the name of the $oldFileSource but the file will be the content of the $newFileSource.
     *
     * @param string $oldFileSource The path to the old file which should be replace by the new file. e.g `path/to/old.jpp`
     * @param string $newFileSource The path to the new file which is going to have the same name as the old file e.g. `path/of/new.jpg`.
     * @return boolean Whether moving was successfull or not.
     */
    public static function replaceFile($oldFileSource, $newFileSource)
    {
        $toDelete = $oldFileSource . uniqid('oldfile') . '.bkl';
        if (rename($oldFileSource, $toDelete)) {
            if (copy($newFileSource, $oldFileSource)) {
                @unlink($toDelete);
                return true;
            }
        }
        return false;
    }
    
    /**
     * Add File to the storage container by providing the $_FILES array name.
     *
     * Example usage:
     *
     * ```php
     * $return = Storage::uploadFromFileArray($_FILES['image'], 0, true);
     * ``
     *
     * Example response
     *
     * ```php
     * ['upload' => false, 'message' => 'file uploaded succesfully', 'file_id' => 123], // success response example
     * ['upload' => true, 'message' => 'No file was uploaded.', 'file_id' => 0], // error response example
     * ```
     *
     * @param array $fileArray Its an entry of the files array like $_FILES['logo_image'].
     * @param integer $toFolder The id of the folder the file should be uploaded to, see {{luya\admin\components\StorageContainer::findFolders}}
     * @param string $isHidden Whether the file should be hidden or not.
     * @return array An array with key `upload`, `message` and `file_id`. When upload is false, an error occured otherwise true. The message key contains the error messages. If no error happend `file_id` will contain the new uploaded file id.
     */
    public static function uploadFromFileArray(array $fileArray, $toFolder = 0, $isHidden = false)
    {
        $files = self::extractFilesDataFromFilesArray($fileArray);
        
        if (count($files) !== 1) {
            return ['upload' => false, 'message' => 'no image found', 'file_id' => 0];
        }
        
        return self::verifyAndSaveFile($files[0], $toFolder, $isHidden);
    }
    
    /**
     * Add Files to storage component by just providing $_FILES array, used for multi file storage.
     *
     * Example usage:
     *
     * ```php
     * $return = Storage::uploadFromFiles($_FILES, 0, true);
     * ```
     *
     * Example response
     *
     * ```php
     * ['upload' => false, 'message' => 'file uploaded succesfully', 'file_id' => 123], // success response example
     * ['upload' => true, 'message' => 'No file was uploaded.', 'file_id' => 0], // error response example
     * ```
     *
     * @todo what happen if $files does have more then one entry, as the response is limit to 1
     * @param array $filesArray Use $_FILES array.
     * @param integer $toFolder The id of the folder the file should be uploaded to, see {{luya\admin\components\StorageContainer::findFolders}}
     * @param string $isHidden Whether the file should be hidden or not.
     * @return array An array with key `upload`, `message` and `file_id`. When upload is false, an error occured otherwise true. The message key contains the error messages. If no error happend `file_id` will contain the new uploaded file id.
     */
    public static function uploadFromFiles(array $filesArray, $toFolder = 0, $isHidden = false)
    {
        $files = [];
        foreach ($filesArray as $fileArrayKey => $file) {
            $files = array_merge($files, self::extractFilesDataFromFilesArray($file));
        }
    
        foreach ($files as $file) {
            return self::verifyAndSaveFile($file, $toFolder, $isHidden);
        }
    
        return ['upload' => false, 'message' => 'no files selected or empty files list.', 'file_id' => 0];
    }
    
    
    private static function extractFilesDataFromFilesArray(array $file)
    {
        $files = [];
        if (is_array($file['tmp_name'])) {
            foreach ($file['tmp_name'] as $index => $value) {
                $files[] = [
                    'name' => $file['name'][$index],
                    'type' => $file['type'][$index],
                    'tmp_name' => $file['tmp_name'][$index],
                    'error' => $file['error'][$index],
                    'size' => $file['size'][$index],
                ];
            }
        } else {
            $files[] = [
                'name' => $file['name'],
                'type' => $file['type'],
                'tmp_name' => $file['tmp_name'],
                'error' => $file['error'],
                'size' => $file['size'],
            ];
        }
        
        return $files;
    }
    
    private static function verifyAndSaveFile(array $file, $toFolder = 0, $isHidden = false)
    {
        try {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => static::$uploadErrors[$file['error']], 'file_id' => 0];
            }
    
            $file = Yii::$app->storage->addFile($file['tmp_name'], $file['name'], $toFolder, $isHidden);
            if ($file) {
                return ['upload' => true, 'message' => 'file uploaded succesfully', 'file_id' => $file->id];
            }
        } catch (Exception $err) {
            return ['upload' => false, 'message' => $err->getMessage(), 'file_id' => 0];
        }
        
        return ['upload' => false, 'message' => 'no files selected or empty files list.', 'file_id' => 0];
    }
}
