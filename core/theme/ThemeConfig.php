<?php

namespace luya\theme;

use luya\helpers\FileHelper;
use Yii;
use luya\helpers\Json;
use yii\base\Arrayable;
use yii\base\ArrayableTrait;
use yii\base\BaseObject;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;

/**
 * Load the config from the theme.json file and the config inheritance from the parent theme.
 *
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since 1.0.21
 */
class ThemeConfig extends BaseObject implements Arrayable
{
    use ArrayableTrait;
    
    protected $_basePath;
    
    /**
     * @var string The pretty name of the theme.
     */
    public $name;
    
    /**
     * @var string Base path (or alias) of the parent theme.
     */
    public $parentTheme;
    
    /**
     * @var array Additional path to override by this theme.
     * @see \luya\theme\Theme::getAdditionalPathMap
     */
    public $pathMap = [];
    
    /**
     * @var string Some information about the theme.
     */
    public $description;
    
    /**
     * ThemeConfig constructor with base path of the theme directory and config as array.
     *
     * @param string $basePath The base path of the theme.
     * @param array  $config key-value pair
     *
     * @throws InvalidConfigException
     */
    public function __construct(string $basePath, array $config)
    {
        if (!is_readable(Yii::getAlias($basePath))) {
            throw new InvalidConfigException("The path of $basePath is not readable or not exists.");
        }
    
        $this->_basePath = $basePath;
    
        parent::__construct($config);
    }
    
    /**
     * @inheritDoc
     */
    public function init()
    {
        if (empty($this->name)) {
            $this->name = basename($this->_basePath);
        }
        
        parent::init();
    }
    
    protected $_parent;
    
    /**
     * Load the config of the parent theme.
     *
     * @return ThemeConfig
     * @throws InvalidConfigException
     * @throws \luya\Exception
     */
    public function getParent()
    {
        if ($this->_parent === null && $this->parentTheme) {
            $this->_parent = Yii::$app->themeManager->getThemeByBasePath($this->parentTheme);
        }
        
        return $this->_parent;
    }
    
    /**
     * Set the parent theme config. Is only required while initialize this class.
     *
     * @param ThemeConfig $themeConfig
     */
    protected function setParent(ThemeConfig $themeConfig)
    {
        $this->_parent = $themeConfig;
    }
    
    /**
     * Load all parent themes recursive in a ordered array. First entry is the parent of this theme, seconds entry is the parent of the parent and so on.
     *
     * @return array
     * @throws InvalidConfigException
     * @throws \luya\Exception
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
    
    /**
     * Base path (or alias) to the theme directory.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->_basePath;
    }
    
    /**
     * Path to view directory of the theme.
     *
     * @return string
     */
    public function getViewPath()
    {
        return $this->getBasePath() . '/views';
    }
}