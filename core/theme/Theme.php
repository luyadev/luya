<?php

namespace luya\theme;

use yii\base\InvalidConfigException;

/**
 * Extend the yii2 theme component and build up the `$pathMap` depends on given {{\luya\theme\ThemeConfig}} which include parents inheritance.
 *
 * @property string $layout
 * @property string $viewPath
 * @property string $layoutPath
 * @property string $resourcePath
 *
 * @see \luya\theme\ThemeConfig
 * @author Bennet Klarhoelter <boehsermoe@me.com>
 * @since 1.0.21
 */
class Theme extends \yii\base\Theme
{
    public const LAYOUTS_PATH = 'layouts';

    private $_config;

    /**
     * Theme constructor with a configuration as {{\luya\theme\ThemeConfig}} object.
     *
     * @param ThemeConfig $config configuration for this theme.
     */
    public function __construct(ThemeConfig $config)
    {
        $this->_config = $config;
        parent::__construct(['basePath' => $config->getBasePath()]);
    }

    /**
     * Initialize the theme.
     *
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->getBasePath() === null) {
            throw new InvalidConfigException("Property base path must be set");
        }

        $this->initPathMap($this->_config);

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

    /**
     * The name of the layout to be applied to this theme views.
     *
     * @return string Default `theme`
     */
    public function getLayout()
    {
        return $this->_layout;
    }

    /**
     * Path to the directory that contains the theme views.
     *
     * @return string
     */
    public function getViewPath()
    {
        return $this->getConfig()->getViewPath();
    }

    /**
     * Path to the directory that contains the theme layouts.
     *
     * @return string
     */
    public function getLayoutPath()
    {
        return $this->viewPath . '/' . self::LAYOUTS_PATH;
    }

    /**
     * Theme configuration that contains the base theme information.
     *
     * @return ThemeConfig
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * @param ThemeConfig $themeConfig
     *
     * @return array
     * @throws InvalidConfigException
     * @throws \luya\Exception
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
