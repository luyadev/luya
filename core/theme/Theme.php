<?php

namespace luya\theme;

use luya\helpers\Json;
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
    }
    
    /**
     * Init the path mapping include the parent themes
     */
    protected function initPathMap(ThemeConfig $themeConfig)
    {
        $viewPath = $this->getViewPath();
        $this->pathMap[$viewPath] = null;
    
        $pathMap = ['@app/views', $themeConfig->getViewPath()];
        
        foreach ($themeConfig->getParents() as $parentConfig) {
            $pathMap[] = $parentConfig->getViewPath();
            $this->pathMap[$parentConfig->getViewPath()] = null;
        }
    
        foreach ($themeConfig->getPathMap() as $from) {
            $this->pathMap[$from] = null;
        }
    
        foreach ($this->pathMap as $from => &$tos) {
            $tos = $pathMap;
        }
    
        $pos = strpos($viewPath, '/');
        $rootPath = $pos === false ? $viewPath : (substr($viewPath, 0, $pos) . '/views');
        $this->pathMap[$rootPath] = $pathMap;
    }
    
    protected $_layout = 'main';
    
    public function getLayout(): string
    {
        return $this->_layout;
    }
    
    public function getViewPath(): string
    {
        return $this->config->getViewPath();
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
        return $this->basePath . '/resources';
    }
    
    public function getConfig()
    {
        return $this->config;
    }
}