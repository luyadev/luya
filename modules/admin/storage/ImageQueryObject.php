<?php

namespace admin\storage;

use Yii;
use admin\storage\FileQuery;

class ImageQueryObject extends \yii\base\Object
{
    use \admin\storage\ObjectTrait;
    
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
        return ($this->getFile()) ? Yii::$app->storagecontainer->httpPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName() : false;
    }
    
    public function getFile()
    {
        return (new FileQuery())->findOne($this->getFileId());
    }
    
    public function applyFilter($filterName)
    {
        return ($filterItem = Yii::$app->storagecontainer->getFiltersArrayItem($filterName)) ? Yii::$app->storagecontainer->addImage($this->getFileId(), $filterItem['id']) : false;
    }
}
