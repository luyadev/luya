<?php

namespace luya\theme;

use luya\helpers\FileHelper;
use Yii;
use luya\helpers\Json;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Load the config from the theme.json file and the config inheritance from the parent theme.
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since 1.1.0
 */
class ThemeConfig extends BaseObject implements Arrayable
{
    use ArrayableTrait;
    
    protected $_basePath;
    
    public $name;
    public $parentTheme;
    public $description;
    public $author;
    public $image;
    
    public function __construct(string $basePath)
    {
        if (!is_readable(Yii::getAlias($basePath))) {
            throw new InvalidConfigException("The path of $basePath is not readable or not exists.");
        }
        
        $config = [];
        
        $themeFile = Yii::getAlias($basePath . '/theme.json');
        if (file_exists($themeFile)) {
            $config = Json::decode(file_get_contents($themeFile)) ?: [];
        }
        
        $this->_basePath = $basePath;
    
        parent::__construct($config);
    }
    
    public function init()
    {
        if (empty($this->name)) {
            $this->name = basename($this->_basePath);
        }
    }
    
    public function getBasePath()
    {
        return $this->_basePath;
    }
    
    protected $_parent;
    
    /**
     * @return ThemeConfig
     */
    public function getParent()
    {
        if ($this->parentTheme) {
            $this->_parent = new ThemeConfig($this->parentTheme);
        }
        
        return $this->_parent;
    }
    
    /**
     * Load the parent themes recursive.
     *
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
    
    public function getViewPath(): string
    {
        return $this->getBasePath() . '/views';
    }
    
    
}