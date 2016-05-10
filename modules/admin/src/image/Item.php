<?php

namespace admin\image;

use Yii;

/**
 * Image Item Detail Object.
 * 
 * Each image is represent as Item-Object class.
 * 
 * @property string $caption Image Caption
 * @property integer $id The unique image identifier number.
 * @property integer $fileId The file id where this image depends on.
 * @property integer $filterId The applied filter id for this image
 * @property string $source The source of the image where you can access the image by the web.
 * @property string $serverSource The source to the image internal used on the Server.
 * @property boolean $fileExists Return boolean whether the file server source exsits on the server or not.
 * @property string $resolutionWidth Get the image resolution width.
 * @property string $resolutionHeight Get the image resolution height.
 * @property \admin\file\Item $file The file object where the image was created from.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Item extends \yii\base\Object
{
    use \admin\storage\ItemTrait;
    
    private $_file = null;
    
    private $_caption = null;
    
    /**
     * Set caption for image item, override existings values
     * 
     * @param string $text The caption text for this image
     * @since 1.0.0-beta7
     */
    public function setCaption($text)
    {
        $this->_caption = trim($text);
    }
    
    /**
     * Return the caption text for this image, if not defined or none give its null
     * 
     * @return string The caption text for this image
     * @since 1.0.0-beta7
     */
    public function getCaption()
    {
        return $this->_caption;
    }
    
    /**
     * The unique image identifier number.
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    /**
     * The file id where this image depends on.
     * 
     * @return integer
     */
    public function getFileId()
    {
        return $this->itemArray['file_id'];
    }

    /**
     * The applied filter id for this image
     * 
     * @return integer
     */
    public function getFilterId()
    {
        return $this->itemArray['filter_id'];
    }
    
    /**
     * The source of the image where you can access the image by the web.
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
     * The source to the image internal used on the Server.
     * 
     * @return string|boolean
     */
    public function getServerSource()
    {
        return ($this->getFile()) ? Yii::$app->storage->serverPath . '/' . $this->getFilterId() . '_' . $this->getFile()->getSystemFileName() : false;
    }
    
    /**
     * Return boolean value whether the file server source exsits on the server or not.
     * 
     * @return boolean
     */
    public function getFileExists()
    {
        return file_exists($this->getServerSource());
    }
    
    /**
     * Get the image resolution width.
     * 
     * @return mixed
     */
    public function getResolutionWidth()
    {
        return $this->itemArray['resolution_width'];
    }
    
    /**
     * Get the image resolution height.
     * 
     * @return mixed
     */
    public function getResolutionHeight()
    {
        return $this->itemArray['resolution_height'];
    }
    
    /**
     * Get image depending file object where the image was create from, its like the original Source
     * 
     * @return \admin\file\Item
     */
    public function getFile()
    {
        if ($this->_file === null) {
            $this->_file = Yii::$app->storage->getFile($this->getFileId());
        }
        
        return $this->_file;
    }
    
    /**
     * Apply a new filter for the original ussed file and return the new created image object.
     * 
     * @param string $filterName The name of a filter like `tiny-thumbnail` or a custom filter you have defined in your filters list.
     * @return boolean|\admin\image\Item Returns boolean or image item object if its found.
     */
    public function applyFilter($filterName)
    {
        return ($filterItem = Yii::$app->storage->getFiltersArrayItem($filterName)) ? Yii::$app->storage->addImage($this->getFileId(), $filterItem['id']) : false;
    }
    
    /**
     * Get the image object informations as array.
     * 
     * @return array 
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
