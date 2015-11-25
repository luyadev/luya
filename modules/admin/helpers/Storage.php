<?php

namespace admin\helpers;

use Exception;
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
}
