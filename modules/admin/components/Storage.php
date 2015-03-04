<?php
namespace admin\components;

/**
 * 
 * @author nadar
 */
class Storage extends \yii\base\Component
{
    private $files = null;
    
    private $filters = null;
    
    private $effects = null;
    
    private $images = null;
    
    public function getFiles()
    {
        if (empty($this->files)) {
            $this->files = new \admin\storage\Files();
        }
        
        return $this->files;
    }
    
    public function getFilters()
    {
        if (empty($this->filters)) {
            $this->filters = new \admin\storage\Filters();
        }
        
        return $this->filters;
    }
    
    public function getEffects()
    {
        if (empty($this->effects)) {
            $this->effects = new \admin\storage\Effects();
        }
        
        return $this->effects;
    }
    
    public function getImages()
    {
        if (empty($this->images)) {
            $this->images = new \admin\storage\Images();
        }
        
        return $this->images;
    }
    
}