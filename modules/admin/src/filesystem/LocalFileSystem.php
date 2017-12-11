<?php

namespace luya\admin\filesystem;

use Yii;
use luya\admin\storage\BaseFileSystemStorage;
use luya\helpers\FileHelper;
use luya\helpers\Url;
use luya\Exception;

class LocalFileSystem extends BaseFileSystemStorage
{
    private $_httpPath;
    
    public $folderName = 'storage';
    
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
     *     'class' => 'luya\admin\filesystem\LocalFileSystem',
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
     * @inheritdoc
     */
    public function getHttpPath()
    {
        if ($this->_httpPath === null) {
            $this->_httpPath = $this->request->baseUrl . '/' . $this->folderName;
        }
    
        return $this->_httpPath;
    }
    
    private $_absoluteHttpPath;
    
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
     *     'class' => 'admin\storage\BaseFileSystemStorage',
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
     * @inheritdoc
     */
    public function getAbsoluteHttpPath()
    {
        if ($this->_absoluteHttpPath === null) {
            $this->_absoluteHttpPath = Url::base(true) . '/' . $this->folderName;
        }
    
        return $this->_absoluteHttpPath;
    }
    
    private $_serverPath;
    
    /**
     * @inheritdoc
     */
    public function getServerPath()
    {
        if ($this->_serverPath === null) {
            $this->_serverPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . $this->folderName;
        }
    
        return $this->_serverPath;
    }
    
    public function setServerPath($path)
    {
        $this->_serverPath = $path;
    }

    /**
     * @inheritdoc
     */
    public function fileSystemSaveFile($source, $fileName)
    {
        $savePath = $this->getServerPath() . '/' . $fileName;
        
        if (is_uploaded_file($source)) {
            if (!@move_uploaded_file($source, $savePath)) {
                throw new Exception("error while moving uploaded file from $source to $savePath");
            }
        } else {
            if (!@copy($source, $savePath)) {
                throw new $source("error while copy file from $source to $savePath.");
            }
        }

        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function fileSystemReplaceFile($oldSource, $newSource)
    {
        $toDelete = $oldSource . uniqid('oldfile') . '.bkl';
        if (rename($oldSource, $toDelete)) {
            if (copy($newSource, $oldSource)) {
                @unlink($toDelete);
                return true;
            }
        }
        return false;
    }
    
    /**
     * @inheritdoc
     */
    public function fileSystemDeleteFile($source)
    {
        return FileHelper::unlink($source);
    }
}
