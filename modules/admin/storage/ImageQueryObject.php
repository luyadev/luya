<?php

namespace admin\storage;

use Yii;
use admin\storage\FileQuery;

class ImageQueryObject extends \yii\base\Object
{
    public $itemArray = [];
    
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
        return Yii::$app->storagecontainer->httpPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName();
    }
    
    public function getFile()
    {
        return (new FileQuery())->findOne($this->getFileId());
    }
}
