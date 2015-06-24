<?php

namespace admin\components;

use Yii;
use \luya\helpers\Url;

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

    public $dir = '@webroot/storage';
    
    public $httpDir = 'storage';
    
    public function init()
    {
        $this->dir = Url::trailing(Yii::getAlias($this->dir), DIRECTORY_SEPARATOR);
        $this->httpDir = Url::trailing($this->httpDir, DIRECTORY_SEPARATOR);
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
}
