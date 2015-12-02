<?php

namespace admin\helpers;

use Exception;
use Yii;
use admin\models\StorageFile;

class Storage
{
    /**
     * Warning
     * Because PHP's integer type is signed many crc32 checksums will result in negative integers on 32bit platforms. On 64bit installations all crc32() results will be positive integers though.
     * So you need to use the "%u" formatter of sprintf() or printf() to get the string representation of the unsigned crc32() checksum in decimal format.
     *
     * @var string
     */
    public static function createFileHash($fileName)
    {
        return sprintf('%s', hash('crc32b', uniqid($fileName, true)));
    }
    
    
    public static function removeFile($fileId)
    {
        $model = StorageFile::find()->where(['id' => $fileId, 'is_deleted' => 0])->one();
        if ($model) {
            return $model->delete();
        }
    
        return true;
    }
    
    
    /**
     * 
     * @param string $filePath
     * @return array
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
    
    public static function moveFilesToFolder($fileIds, $folderId)
    {
        foreach ($fileIds as $fileId) {
            static::moveFileToFolder($fileId, $folderId);
        }
    }
    
    public static function moveFileToFolder($fileId, $folderId)
    {
        $file = StorageFile::findOne($fileId);
        $file->folder_id = $folderId;
    
        return $file->update(false);
    }
    
    private static $uploaderErrors = [
        0 => 'There is no error, the file uploaded with success',
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk.',
        8 => 'A PHP extension stopped the file upload.',
    ];
    
    public static function uploadFromFiles(array $filesArray, $toFolder = 0)
    {
        $files = [];
        foreach ($filesArray as $k => $file) {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return ['upload' => false, 'message' => static::$uploaderErrors[$file['error']], 'file_id' => 0];
            }
            try {
                $file = Yii::$app->storage->addFile($file['tmp_name'], $file['name'], $toFolder);
                if ($file) {
                    return ['upload' => true, 'message' => 'file uploaded succesfully', 'file_id' => $file->id];
                }
            } catch (Exception $err) {
                return ['upload' => false, 'message' => $err->getMessage()];
            }
        }
    
        return ['upload' => false, 'message' => 'no files selected', 'file_id' => 0];
    }
}
