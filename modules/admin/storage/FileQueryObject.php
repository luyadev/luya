<?php

namespace admin\storage;

use Yii;
use luya\helpers\Url;
use admin\storage\FolderQuery;

class FileQueryObject extends \yii\base\Object
{
    use \admin\storage\ObjectTrait;
    
    private $_imageMimeTypes = ['image/gif', 'image/jpeg', 'image/png'];
    
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    public function getFolderId()
    {
        return $this->itemArray['folder_id'];
    }
    
    public function getFolder()
    {
        return (new FolderQuery())->findOne($this->getFolderId());
    }
    
    public function getName()
    {
        return $this->itemArray['name_original'];
    }
    
    public function getSystemFileName()
    {
        return $this->itemArray['name_new_compound'];
    }
    
    public function getMimeType()
    {
        return $this->itemArray['mime_type'];
    }
    
    public function getExtension()
    {
        return $this->itemArray['extension'];
    }
    
    public function getUploadTimestamp()
    {
        return $this->itemArray['upload_timestamp'];
    }
    
    public function getIsImage()
    {
        return in_array($this->getMimeType(), $this->_imageMimeTypes);
    }
    
    /**
     * Delivers the url for nice urls /file/id/hash/hello-world.jpg
     * 
     * @return string
     */
    public function getSource()
    {
        return Yii::$app->storage->httpPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    /**
     * @return string
     */
    public function getHttpSource()
    {
        return Yii::$app->storage->httpPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    public function getServerSource()
    {
        return Yii::$app->storage->serverPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'folderId' => $this->getFolderId(),
            'name' => $this->getName(),
            'systemFileName' => $this->getSystemFileName(),
            'source' => $this->getSource(),
            'httpSource' => $this->getHttpSource(),
            'serverSource' => $this->getServerSource(),
            'isImage' => $this->getIsImage(),
            'mimeType' => $this->getMimeType(),
            'extension' => $this->getExtension(),
            'uploadTimestamp' => $this->getUploadTimestamp(),
        ];
    }
}
