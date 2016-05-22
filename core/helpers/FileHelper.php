<?php

namespace luya\helpers;

use Yii;
use admin\ngrest\plugins\File;
use Exception;

/**
 * Extending the Yii File Helper class.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class FileHelper extends \yii\helpers\BaseFileHelper
{
    /**
     * Generate a human readable size informations from provided Byte/s size
     * 
     * @param integer $size The size to convert in Byte
     * @return string The readable size definition
     */
    public static function humanReadableFilesize($size)
    {
        $mod = 1024;
        $units = explode(' ', 'B KB MB GB TB PB');
        for ($i = 0; $size > $mod; ++$i) {
            $size /= $mod;
        }

        return round($size, 2).' '.$units[$i];
    }

    /**
     * Append a file extension to a path/file if there is no or an empty extension provided, this
     * helper methods is used to make sure the right extension existing on files.
     * 
     * @param string $file The file where extension should be append if not existing
     * @param string $extension
     * @return the ensured file/path with extension
     */
    public static function ensureExtension($file, $extension)
    {
        $info = pathinfo($file);
        if (!isset($info['extension']) || empty($info['extension'])) {
            $file = rtrim($file, '.') . '.' . $extension;
        }

        return $file;
    }
    
    /**
     * Get extension and name from a file for the provided source/path of the file.
     * 
     * @param string $sourceFile The path of the file
     * @return object With extension and name keys.
     */
    public static function getFileInfo($sourceFile)
    {
        $path = pathinfo($sourceFile);
    
        return (object) [
            'extension' => isset($path['extension']) ? (empty($path['extension']) ? false : $path['extension']) : false,
            'name' => isset($path['filename']) ? $path['filename'] : false,
        ];
    }
    
    /**
     * Generate a md5 hash of a file. This is eqauls to `md5sum` command
     * 
     * @param string $sourceFile The path to the file
     * @return false|string Returns false or the md5 hash of this file
     */
    public static function getFileHash($sourceFile)
    {
        return file_exists($sourceFile) ? hash_file('md5', $sourceFile) : false;
    }
    
    /**
     * Basic helper method to write files with exception capture. The fileName will auto wrapped
     * trough the Yii::getAlias function.
     * 
     * @param string $fileName The path to the file with file name
     * @param string $content The content to store in this File
     * @return boolean
     */
    public static function writeFile($fileName, $content)
    {
        try {
            return file_put_contents(Yii::getAlias($fileName), $content);
        } catch (Exception $error) {
            return false;
        }
    }
    
    /**
     * Basic helper to retreive the content of a file and catched exception. The filename
     * will auto alias encode by Yii::getAlias function.
     * 
     * @since 1.0.0-beta7
     * @param sring $fileName The path to the file to get the content
     * @return string|boolean
     */
    public static function getFileContent($fileName)
    {
    	try {
    		return file_get_contents(Yii::getAlias($fileName));
    	} catch (Exception $error) {
    		return false;
    	}
    }
}
