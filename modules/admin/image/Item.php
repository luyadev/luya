<?php

namespace admin\image;

use Yii;

class Item extends \yii\base\Object
{
    use \admin\storage\ItemTrait;
    
    private $_file = null;
    
    /**
     * 
     * @return mixed
     */
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    /**
     * 
     * @return mixed
     */
    public function getFileId()
    {
        return $this->itemArray['file_id'];
    }

    /**
     * 
     */
    public function getFilterId()
    {
        return $this->itemArray['filter_id'];
    }
    
    /**
     * 
     * @return string|boolean
     */
    public function getSource()
    {
        if (!$this->getFileExists()) {
            // The image source does not exist, probably it has been deleted due to filter changes.
            // Storage-Component is going go try to re-create this image now.
            $apply = Yii::$app->storage->addImage($this->getFileId(), $this->getFilterId());
        }
        
        return ($this->getFile()) ? Yii::$app->storage->httpPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName() : false;
    }
    
    /**
     * 
     * @return string|boolean
     */
    public function getServerSource()
    {
        return ($this->getFile()) ? Yii::$app->storage->serverPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName() : false;
    }
    
    /**
     * 
     * @return boolean
     */
    public function getFileExists()
    {
        return file_exists($this->getServerSource());
    }
    
    /**
     * 
     * @return mixed
     */
    public function getResolutionWidth()
    {
        return $this->itemArray['resolution_width'];
    }
    
    /**
     * 
     * @return mixed
     */
    public function getResolutionHeight()
    {
        return $this->itemArray['resolution_height'];
    }
    
    /**
     * 
     */
    public function getFile()
    {
        if ($this->_file === null) {
            $this->_file = Yii::$app->storage->getFile($this->getFileId());
        }
        
        return $this->_file;
    }
    
    /**
     * 
     * @param unknown $filterName
     * @return boolean
     */
    public function applyFilter($filterName)
    {
        return ($filterItem = Yii::$app->storage->getFiltersArrayItem($filterName)) ? Yii::$app->storage->addImage($this->getFileId(), $filterItem['id']) : false;
    }
    
    /**
     * 
     * @return string[]|boolean[]|mixed[]
     */
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
