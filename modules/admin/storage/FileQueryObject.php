<?php

namespace admin\storage;

use Yii;
use luya\helpers\Url;

class FileQueryObject extends \yii\base\Object
{
    public $itemArray = null;
    
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    public function getFolderId()
    {
        return $this->itemArray['folder_id'];
    }
    
    public function getName()
    {
        return $this->itemArray['name_original'];
    }
    
    public function getSystemFileName()
    {
        return $this->itemArray['name_new_compound'];
    }
    
    /**
     * Delivers the url for nice urls /file/id/hash/hello-world.jpg
     * 
     * @return string
     */
    public function getSource()
    {
        return Yii::$app->storagecontainer->httpPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    /**
     * @return string
     */
    public function getHttpSource()
    {
        return Yii::$app->storagecontainer->httpPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    public function getServerSource()
    {
        return Yii::$app->storagecontainer->serverPath . '/' . $this->itemArray['name_new_compound'];
    }
}