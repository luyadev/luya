<?php

namespace luya\theme;

use luya\helpers\Json;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Class Theme
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 *
 * @property-read string $name
 * @property-read string $path
 * @property-read string $layout
 * @property-read string $viewPath
 * @property-read string $layoutPath
 * @property-read string $layoutFile
 * @property-read string $resourcePath
 */
class Theme extends BaseObject
{
    public function init()
    {
        if ($this->getPath() === null) {
            throw new InvalidConfigException("Property path must be set");
        }
        
        Yii::configure($this, $this->getThemeData());
    }
    
    protected $_path = null;
    
    public function getPath(): string
    {
        return $this->_path;
    }
    
    protected function setPath(string $path)
    {
        $this->_path = $path;
    }
    
    protected $_layout = 'main';
    
    public function getLayout(): string
    {
        return $this->_layout;
    }
    
    public function getViewPath(): string
    {
        return $this->path . '/views';
    }
    
    public function getLayoutPath(): string
    {
        return $this->viewPath . '/layouts';
    }
    
    public function getLayoutFile()
    {
        return $this->layoutPath . '/' . $this->layout . '.php';
    }
    
    public function getResourcePath()
    {
        return $this->path . '/resources';
    }
    
    private $_name;
    
    public function getName()
    {
        if ($this->_name) {
            return $this->_name;
        }
        
        return basename($this->path);
    }
    
    protected function setName(string $name)
    {
        $this->_name = $name;
    }
    
    /**
     *
     * Read theme info from JSON theme file
     *
     * @return array
     */
    protected function getThemeData()
    {
        $themeFile = Yii::getAlias($this->path . '/theme.json');
        if (file_exists($themeFile)) {
            $data = Json::decode(file_get_contents($themeFile));
            
            if ($data === false) {
                return [];
            }
            
            return [
                'name' => $data->name,
                'description' => $data->description,
                'author' => $data->author,
                'image' => $data->image,
            ];
        }
        
        return [];
    }
    
    public function getInfo()
    {
        return [
            'name' => $this->name,
            'path' => $this->path,
        ];
    }
}