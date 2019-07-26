<?php

namespace luya\theme;

use luya\helpers\Json;
use Yii;
use yii\base\BaseObject;
use yii\base\InvalidConfigException;

/**
 * Extend the yii2 theme component and build the correct `$pathMap`
 * depends on given ThemeConfig include parents inheritance.
 *
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
        parent::__construct(['basePath' => $config->basePath]);
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
        $pathMap = ['@app/views', $themeConfig->getViewPath()];
    
        foreach ($themeConfig->getParents() as $parent) {
            $pathMap[] = $parent->getViewPath();
            $this->pathMap[$this->getViewPath()] = $pathMap;
        }
        
        $this->pathMap['@app/views'] = $pathMap;
    }
    
    protected $_layout = 'main';
    
    public function getLayout(): string
    {
        return $this->_layout;
    }
    
    public function getViewPath(): string
    {
        return $this->basePath . '/views';
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
    
    public function getInfo()
    {
        return [
            'name' => $this->config->getName(),
            'path' => $this->basePath,
        ];
    }
}