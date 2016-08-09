<?php

namespace admin\file;

use Yii;
use luya\helpers\Url;
use luya\helpers\FileHelper;
use admin\helpers\I18n;

/**
 * Storage File Item
 * 
 * @property string $catpion The file caption
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Item extends \yii\base\Object
{
    use \admin\storage\ItemTrait;
    
    private $_imageMimeTypes = ['image/gif', 'image/jpeg', 'image/png'];
    
    private $_caption = null;
    
    /**
     * Set caption for file item, override existings values
     *
     * @param string $text The caption text for this image
     * @since 1.0.0-beta7
     */
    public function setCaption($text)
    {
        $this->_caption = trim($text);
    }
    
    /**
     * Return the caption text for this file, if not defined the item array will be collected
     *
     * @return string The caption text for this image
     * @since 1.0.0-beta7
     */
    public function getCaption()
    {
        if ($this->_caption === null) {
            $this->_caption = I18n::findCurrent($this->getCaptionArray());
        }
    
        return $this->_caption;
    }
    
    public function getCaptionArray()
    {
        return I18n::decode($this->itemArray['caption']);
    }
    
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
    public function getFolderId()
    {
        return $this->itemArray['folder_id'];
    }
    
    /**
     * 
     */
    public function getFolder()
    {
        return Yii::$app->storage->getFolder($this->getFolderId());
    }
    
    /**
     * 
     * @return mixed
     */
    public function getName()
    {
        return $this->itemArray['name_original'];
    }
    
    /**
     * 
     * @return mixed
     */
    public function getSystemFileName()
    {
        return $this->itemArray['name_new_compound'];
    }
    
    /**
     * 
     * @return mixed
     */
    public function getMimeType()
    {
        return $this->itemArray['mime_type'];
    }
    
    /**
     * 
     * @return mixed
     */
    public function getExtension()
    {
        return $this->itemArray['extension'];
    }
    
    /**
     * 
     * @return mixed
     */
    public function getSize()
    {
        return $this->itemArray['file_size'];
    }
    
    /**
     * 
     * @return string
     */
    public function getSizeReadable()
    {
        return FileHelper::humanReadableFilesize($this->getSize());
    }
    
    /**
     * 
     * @return mixed
     */
    public function getUploadTimestamp()
    {
        return $this->itemArray['upload_timestamp'];
    }
    
    /**
     * 
     * @return boolean
     */
    public function getIsImage()
    {
        return in_array($this->getMimeType(), $this->_imageMimeTypes);
    }
    
    /**
     * 
     * @return mixed
     */
    public function getHashName()
    {
        return $this->itemArray['hash_name'];
    }
    
    /**
     * Delivers the url for nice urls /file/id/hash/hello-world.jpg
     * 
     * @return string
     */
    public function getSource()
    {
        return Url::toManager('admin/file/download', ['id' => $this->getId(), 'hash' => $this->getHashName(), 'fileName' => $this->getName()]);
    }
    
    /**
     * Delivers the url for nice urls /file/id/hash/hello-world.jpg
     *
     * @return string
     */
    public function getSourceStatic()
    {
        return Url::toRoute(['/admin/file/download', 'id' => $this->getId(), 'hash' => $this->getHashName(), 'fileName' => $this->getName()], true);
    }
    
    /**
     * @return string
     */
    public function getHttpSource()
    {
        return Yii::$app->storage->httpPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    /**
     * 
     * @return string
     */
    public function getServerSource()
    {
        return Yii::$app->storage->serverPath . '/' . $this->itemArray['name_new_compound'];
    }
    
    /**
     * Return whether the file is hidden or not
     * 
     * @since 1.0.0-beta7
     * @return boolean
     */
    public function getIsHidden()
    {
        return (bool) $this->itemArray['is_hidden'];
    }
    
    /**
     * Return whether the file is delted or not
     * 
     * @since 1.0.0-beta7
     * @return boolean
     */
    public function getIsDeleted()
    {
        return (bool) $this->itemArray['is_deleted'];
    }
    
    /**
     * 
     * @return string[]|boolean[]|mixed[]
     */
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
            'size' => $this->getSize(),
            'sizeReadable' => $this->getSizeReadable(),
            'caption' => $this->getCaption(),
            'captionArray' => $this->getCaptionArray(),
        ];
    }
}
