<?php

namespace luya\theme;

use Yii;
use luya\helpers\Json;
use yii\base\BaseObject;

class ThemeConfig extends BaseObject
{
    public $basePath;
    public $description;
    public $author;
    public $image;
    
    public function __construct(string $basePath)
    {
        $config = [];
        
        $themeFile = Yii::getAlias($basePath . '/theme.json');
        if (file_exists($themeFile)) {
            $config = Json::decode(file_get_contents($themeFile)) ?: [];
        }
        
        $config['basePath'] = $basePath;
    
        parent::__construct($config);
    }
    
    protected $_parent;
    
    /**
     * @return ThemeConfig
     */
    public function getParent()
    {
        if ($this->getParentTheme()) {
            $this->_parent = new ThemeConfig($this->getParentTheme());
        }
        
        return $this->_parent;
    }
    
    /**
     * @return ThemeConfig[]
     */
    public function getParents()
    {
        $parents = [];
        
        $parent = $this->getParent();
        if ($parent) {
            $parents[] = $parent;
            $parents = array_merge($parents, $parent->getParents());
        }
        
        return $parents;
    }
    
    private $_name;
    
    public function getName()
    {
        if ($this->_name) {
            return $this->_name;
        }
        
        return basename($this->basePath);
    }
    
    protected function setName(string $name)
    {
        $this->_name = $name;
    }
    
    private $_parentTheme;
    
    public function getParentTheme()
    {
        return $this->_parentTheme;
    }
    
    protected function setParentTheme(string $parentTheme = null)
    {
        $this->_parentTheme = $parentTheme;
    }
    
    public function getViewPath(): string
    {
        return $this->basePath . '/views';
    }
}