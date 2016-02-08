<?php

namespace admin\image;

use Yii;

class Item extends \yii\base\Object
{
    use \admin\storage\ItemTrait;
    
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    public function getFileId()
    {
        return $this->itemArray['file_id'];
    }
    
    public function getFilterId()
    {
        return $this->itemArray['filter_id'];
    }
    
    public function getSource()
    {
        if (!$this->getFileExists()) {
            // we try to add the image
            $apply = Yii::$app->storage->addImage($this->getFileId(), $this->getFilterId());
        }
        
        return ($this->getFile()) ? Yii::$app->storage->httpPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName() : false;   
    }
    
    public function getServerSource()
    {
        return ($this->getFile()) ? Yii::$app->storage->serverPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName() : false;
    }
    
    public function getFileExists()
    {
        return file_exists($this->getServerSource());
    }
    
    public function getResolutionWidth()
    {
        return $this->itemArray['resolution_width'];
    }
    
    public function getResolutionHeight()
    {
        return $this->itemArray['resolution_height'];
    }
    
    private $_file = null;
    
    public function getFile()
    {
        if ($this->_file === null) {
            $this->_file = Yii::$app->storage->getFile($this->getFileId());
        }
        
        return $this->_file;
    }
    
    public function applyFilter($filterName)
    {
        return ($filterItem = Yii::$app->storage->getFiltersArrayItem($filterName)) ? Yii::$app->storage->addImage($this->getFileId(), $filterItem['id']) : false;
    }
    
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'fileId' => $this->getFileId(),
            'filterId' => $this->getFilterId(),
            'source' => $this->getSource(),
            'serverSource' => $this->getServerSource(),
            'resolutionWidth' => $this->getResolutionWidth(),
            'resolutionHeight' => $this->getResolutionHeight(),
        ];
    }
}
