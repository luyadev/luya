<?php
namespace admin\components;

/**
 * 
 * @author nadar
 */
class Storage extends \yii\base\Component
{
    private $_files = null;
    
    private $_filters = null;
    
    private $_effects = null;
    
    private $_images = null;
    
    private $_folders = null;
    
    public function getFiles()
    {
        if (empty($this->_files)) {
            $this->_files = new \admin\storage\Files();
        }
        
        return $this->_files;
    }
    
    public function getFilters()
    {
        if (empty($this->_filters)) {
            $this->_filters = new \admin\storage\Filters();
        }
        
        return $this->_filters;
    }
    
    public function getEffects()
    {
        if (empty($this->_effects)) {
            $this->_effects = new \admin\storage\Effects();
        }
        
        return $this->_effects;
    }
    
    public function getImages()
    {
        if (empty($this->_images)) {
            $this->_images = new \admin\storage\Images();
        }
        
        return $this->_images;
    }
    
    public function getFolders()
    {
        if (empty($this->_folders)) {
            $this->_folders = new \admin\storage\Folders();
        }
        
        return $this->_folders;
    }
    
    public function getHttpFolder()
    {
        return \yii::$app->getModule('admin')->storageFolder;
    }
    
}