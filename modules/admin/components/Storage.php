<?php

namespace admin\components;

use Yii;
use luya\helpers\Url;
use admin\storage\File;
use admin\storage\Filter;
use admin\storage\Effect;
use admin\storage\Image;
use admin\storage\Folder;

trigger_error("storage is deprectead", E_USER_NOTICE);

/**
 * @author nadar
 */
class Storage extends \yii\base\Component
{
    private $_file = null;

    private $_image = null;

    private $_folder = null;

    public $dir = '@webroot/storage';

    private $_httpDir = null;

    public function init()
    {
        parent::init();
        $this->dir = Url::trailing(Yii::getAlias($this->dir), DIRECTORY_SEPARATOR);
    }

    public function getHttpDir()
    {
        if ($this->_httpDir === null) {
            $this->_httpDir = Yii::$app->request->baseUrl . '/storage/';
        }
        
        return $this->_httpDir;
    }
    
    public function getFile()
    {
        return ($this->_file === null) ? $this->_file = new File() : $this->_file;
    }

    public function getImage()
    {
        return ($this->_image === null) ? $this->_image = new Image() : $this->_image;
    }

    public function getFolder()
    {
        return ($this->_folder === null) ? $this->_folder = new Folder() : $this->_folder;
    }
}
