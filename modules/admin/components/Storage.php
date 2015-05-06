<?php

namespace admin\components;

use yii;

/**
 * @author nadar
 */
class Storage extends \yii\base\Component
{
    private $_file = null;

    private $_filter = null;

    private $_effect = null;

    private $_image = null;

    private $_folder = null;

    private $_dir = null;

    private $_httpDir = null;

    public function init()
    {
        $this->setDir(yii::getAlias(yii::$app->getModule('admin')->storageFolder));
        $this->setHttpDir(yii::getAlias(yii::$app->getModule('admin')->storageFolderHttp));
    }

    /**
     * @todo remove from file class, should be inside the storage class!
     *
     * @param unknown_type $path
     */
    public function setDir($path)
    {
        $this->_dir = $path;
    }

    public function getDir()
    {
        return \luya\helpers\url::trailing($this->_dir, DIRECTORY_SEPARATOR);
    }

    public function setHttpDir($httpDir)
    {
        $this->_httpDir = $httpDir;
    }

    public function getHttpDir()
    {
        return \luya\helpers\url::trailing($this->_httpDir, '/');
    }

    public function getFile()
    {
        if (empty($this->_file)) {
            $this->_file = new \admin\storage\File();
        }

        return $this->_file;
    }

    public function getFilter()
    {
        if (empty($this->_filter)) {
            $this->_filter = new \admin\storage\Filter();
        }

        return $this->_filter;
    }

    public function getEffect()
    {
        if (empty($this->_effect)) {
            $this->_effect = new \admin\storage\Effect();
        }

        return $this->_effect;
    }

    public function getImage()
    {
        if (empty($this->_image)) {
            $this->_image = new \admin\storage\Image();
        }

        return $this->_image;
    }

    public function getFolder()
    {
        if (empty($this->_folder)) {
            $this->_folder = new \admin\storage\Folder();
        }

        return $this->_folder;
    }

    public function getHttpFolder()
    {
        return \yii::$app->getModule('admin')->storageFolder;
    }
}
