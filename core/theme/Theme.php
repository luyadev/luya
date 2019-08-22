<?php

namespace luya\theme;

use luya\helpers\Json;
use luya\helpers\StringHelper;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Extend the yii2 theme component and build up the `$pathMap` depends on given \luya\theme\ThemeConfig which include parents inheritance.
 *
 * @see \luya\theme\ThemeConfig
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 *
 * @property-read string $layout
 * @property-read string $viewPath
 * @property-read string $layoutPath
 * @property-read string $layoutFile
 * @property-read string $resourcePath
 */
class Theme extends \yii\base\Theme
{
    const RESOURCES_PATH = 'resources';
    const LAYOUTS_PATH = 'layouts';
    protected $config;
    
    public function __construct(ThemeConfig $config)
    {
        $this->config = $config;
        parent::__construct(['basePath' => $config->getBasePath()]);
    }
    
    public function init()
    {
        if ($this->getBasePath() === null) {
            throw new InvalidConfigException("Property base path must be set");
        }
        
        $this->initPathMap($this->config);
        
        parent::init();
    }
    
    /**
     * Init the path mapping include the parent themes
     */
    protected function initPathMap(ThemeConfig $themeConfig)
    {
        $pathMap = ['@app/views', $themeConfig->getViewPath()];
    
        $viewPath = $this->getViewPath();
        $this->pathMap[$viewPath] = &$pathMap;
        
        foreach ($themeConfig->getParents() as $parentConfig) {
            $pathMap[] = $parentConfig->getViewPath();
            $this->pathMap[$parentConfig->getViewPath()] = &$pathMap;
        }
    
        $additionalPathMap = $this->getAdditionalPathMap($themeConfig);
        foreach ($additionalPathMap as $from) {
            $this->pathMap[$from] = $pathMap;
        }
    
        $pos = strpos($viewPath, '/');
        $rootPath = $pos === false ? $viewPath : (substr($viewPath, 0, $pos) . '/views');
        $this->pathMap[$rootPath] = $pathMap;
    
        $this->pathMap['@app/views'] = $pathMap;
    }
    
    protected $_layout = 'theme';
    
    public function getLayout()
    {
        return $this->_layout;
    }
    
    public function getViewPath()
    {
        return $this->config->getViewPath();
    }
    
    public function getLayoutPath()
    {
        return $this->viewPath . '/' . self::LAYOUTS_PATH;
    }
    
    public function getLayoutFile()
    {
        return $this->layoutPath . '/' . $this->layout . '.php';
    }
    
    public function getResourcePath()
    {
        return $this->basePath . '/' . self::RESOURCES_PATH;
    }
    
    public function getConfig()
    {
        return $this->config;
    }
    
    /**
     * @param ThemeConfig $themeConfig
     *
     * @return array
     */
    protected function getAdditionalPathMap(ThemeConfig $themeConfig)
    {
        $pathMap = $themeConfig->pathMap;
        
        $parentConfig = $themeConfig->getParent();
        if ($parentConfig) {
            $pathMap = array_merge($pathMap, $this->getAdditionalPathMap($parentConfig));
        }
        
        return $pathMap;
}
}