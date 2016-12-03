<?php

namespace luya\web;

use Yii;
use Twig_Environment;
use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Twig_Extension_Debug;

/**
 * LUYA Twig Component
 *
 * from string:
 *
 * ```
 * $twig = Yii::$app->twig->env(new \Twig_Loader_String());
 * $html = $twig->render(['foo' => 'var']);.
 * ```
 *
 * from file:
 *
 * ```
 * $twig = Yii::$app->twig->env(new \Twig_Loader_Filesystem(\yii::getAlias('@app/views/cmslayouts/')));
 * $html = $twig->render('xyz.twig', ['foo' => 'var']);
 * ```
 *
 * @property \Twig_Environment stringEnv contains a string env object environemnt loaded from a string.
 * @deprecated 1.0.0-RC2 Marked as deprecated and will be removed on 1.0.0 release.
 * @author Basil Suter <basil@nadar.io>
 */
class Twig extends \yii\base\Component
{
    /**
     * Get the twig simple functions array to register.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            'menuFindAll' => function ($container, $parentNavId) {
                return Yii::$app->menu->findAll(['container' => $container, 'parent_nav_id' => $parentNavId]);
            },
            'menuFindOne' => function ($id) {
                return Yii::$app->menu->findOne(['id' => $id]);
            },
            'menuCurrent' => function () {
                return Yii::$app->menu->current;
            },
            'menuCurrentLevel' => function ($level) {
                return Yii::$app->menu->getLevelCurrent($level);
            },
            'menuLevelContainer' => function ($level) {
                return Yii::$app->menu->getLevelContainer($level);
            },
            'asset' => function ($name) {
                return Yii::$app->getAssetManager()->getBundle($name);
            },
            'filterApply' => function ($imageId, $filterIdentifier) {
                return Yii::$app->storage->getImage($imageId)->applyFilter($filterIdentifier);
            },
            'image' => function ($imageId) {
                return Yii::$app->storage->getImage($imageId);
            },
            'element' => function () {
                $args = func_get_args();
                $method = $args[0];
                unset($args[0]);

                return Yii::$app->element->getElement($method, $args);
            },
            't' => function () {
                $args = func_get_args();

                return call_user_func_array(['Yii', 't'], $args);
            },
        ];
    }
    
    private $_stringEnv = null;
    
    /**
     * Get a Twig Environment Object from a string Loader.
     *
     * @return \Twig_LoaderInterface
     */
    public function getStringEnv()
    {
        if ($this->_stringEnv === null) {
            $this->_stringEnv = $this->env(new \Twig_Loader_String());
        }
        
        return $this->_stringEnv;
    }

    /**
     * Generate a new twig environemnt with all functions and filters.
     *
     * @param \Twig_LoaderInterface $loader The Environemnt Loader for the Twig instance.
     */
    public function env($loader)
    {
        $twig = new Twig_Environment($loader, ['autoescape' => false, 'debug' => YII_DEBUG]);
        $twig->addExtension(new Twig_Extension_Debug());
        //$twig->addGlobal('activeUrl', Yii::$app->links->activeUrl);
        $twig->addGlobal('publicHtml', Yii::$app->request->baseUrl);
        foreach ($this->getFunctions() as $name => $lambda) {
            $twig->addFunction(new Twig_SimpleFunction($name, $lambda));
        }
        
        $twig->addFilter(new Twig_SimpleFilter('strftime', function ($timestamp, $format) {
            if (is_numeric($timestamp)) {
                return strftime($format, $timestamp);
            }
            
            return $timestamp;
        }));

        return $twig;
    }
}
