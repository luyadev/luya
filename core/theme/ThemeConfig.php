<?php

namespace luya\theme;

use luya\helpers\FileHelper;
use Yii;
use luya\helpers\Json;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Load the config from the theme.json file and the config inheritance from the parent theme.
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since 1.1.0
 */
class ThemeConfig extends BaseObject
{
    public $basePath;
    public $description;
    public $author;
    public $image;
    
    public function __construct(string $basePath)
    {
        if (!is_readable(Yii::getAlias($basePath))) {
            throw new InvalidConfigException("The base path $basePath is not readable or not exists.");
        }
        
        $config = [];
        
        // @todo do not load the json every time
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