<?php

namespace luya\admin\ngrest;

use Yii;
use luya\admin\ngrest\render\RenderInterface;

/**
 * NgRest Base Object
 *
 * ```php
 * $config = new ngrest\Config();
 * $ngrest = new NgRest($config);
 * ```
 *
 * find from config
 *
 * ```php
 * $config = new NgRest::findConfig($ngRestConfigHash);
 * $ngrest = new NgRest($config);
 * ```
 *
 * render from ngrest
 *
 * ```php
 * $ngrest->render(new RenderCrud());
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class NgRest
{
    private $config;

    private $render;

    /**
     * Create new NgRest Object.
     *
     * @param \luya\admin\ngrest\ConfigInterface $configObject
     */
    public function __construct(ConfigInterface $configObject)
    {
        $configObject->onFinish();
        $this->config = $configObject;
    }

    /**
     * Renders the Config for the Given Render Interface.
     *
     * @param \luya\admin\ngrest\render\RenderInterface $render
     * @return string
     */
    public function render(RenderInterface $render)
    {
        $this->render = $render;
        $this->render->setConfig($this->config);
        return $this->render->render();
    }
    
    /**
     * Generates an NgRest Plugin Object.
     *
     * @param string $className
     * @param string $name
     * @param string $alias
     * @param boolean $i18n
     * @param array $args
     * @return \luya\admin\ngrest\base\Plugin
     */
    public static function createPluginObject($className, $name, $alias, $i18n, $args = [])
    {
        return Yii::createObject(array_merge([
            'class' => $className,
            'name' => $name,
            'alias' => $alias,
            'i18n' => $i18n,
        ], $args));
    }
}
