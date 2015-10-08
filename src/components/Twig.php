<?php

namespace luya\components;

use Yii;

/**
 * from string:
 * $twig = Yii::$app->twig->env(new \Twig_Loader_String());
 * $html = $twig->render(['foo' => 'var']);.
 *
 * from file:
 * $twig = Yii::$app->twig->env(new \Twig_Loader_Filesystem(\yii::getAlias('@app/views/cmslayouts/')));
 * $html = $twig->render('xyz.twig', ['foo' => 'var']);
 *
 * @author nadar
 */
class Twig extends \yii\base\Component
{
    public function getFunctions()
    {
        return [
            'links' => function ($cat, $lang, $parent_nav_id) {
                return Yii::$app->links->findByArguments(['cat' => $cat, 'lang' => $lang, 'parent_nav_id' => (int) $parent_nav_id]);
            },
            'linksFindParent' => function ($level) {
                return \luya\helpers\Menu::parentNavIdByCurrentLink(Yii::$app->links, $level);
            },
            'linkActivePart' => function ($part) {
                return Yii::$app->links->getActiveUrlPart($part);
            },
            'asset' => function ($name) {
                return Yii::$app->getAssetManager()->getBundle($name);
            },
            'filterApply' => function ($imageId, $filterIdentifier) {
                return Yii::$app->storage->image->filterApply($imageId, $filterIdentifier);
            },
            'image' => function ($imageId) {
                return Yii::$app->storage->image->get($imageId);
            },
            'element' => function () {
                $args = func_get_args();
                $method = $args[0];
                unset($args[0]);

                return Yii::$app->element->run($method, $args);
            },
            't' => function () {
                $args = func_get_args();

                return call_user_func_array(['Yii', 't'], $args);
            },
        ];
    }

    public function env($loader)
    {
        $twig = new \Twig_Environment($loader, ['autoescape' => false, 'debug' => YII_DEBUG]);
        $twig->addExtension(new \Twig_Extension_Debug());
        $twig->addGlobal('activeUrl', Yii::$app->links->activeUrl);
        foreach ($this->getFunctions() as $name => $lambda) {
            $twig->addFunction(new \Twig_SimpleFunction($name, $lambda));
        }

        return $twig;
    }
}
