<?php

namespace luya\components;

/**
 * from string:
 * $twig = Yii::$app->twig->env(new \Twig_Loader_String());
 * $html = $twig->render(['foo' => 'var']);.
 *
 * from file:
 * $twig = Yii::$app->twig->env(new \Twig_Loader_Filesystem(\yii::getAlias('@app/views/cmslayouts/')));
 * $html = $twig->render(['foo' => 'var']);
 *
 * @author nadar
 */
class Twig extends \yii\base\Component
{
    public function getFunctions()
    {
        return [
            'links' => function ($cat, $lang, $parent_nav_id) {
                return \yii::$app->collection->links->findByArguments(['cat' => $cat, 'lang' => $lang, 'parent_nav_id' => (int) $parent_nav_id]);
            },
            'asset' => function ($name) {
                return \yii::$app->getAssetManager()->getBundle($name);
            },
            'filterApply' => function ($imageId, $filterIdentifier) {
                return \yii::$app->luya->storage->image->filterApply($imageId, $filterIdentifier)->source;
            },
            'image' => function($imageId) {
                return \yii::$app->luya->storage->image->get($imageId);
            }
        ];
    }

    public function env($loader)
    {
        $twig = new \Twig_Environment($loader, ['autoescape' => false, 'debug' => true]);
        $twig->addExtension(new \Twig_Extension_Debug());

        foreach ($this->getFunctions() as $name => $lambda) {
            $twig->addFunction(new \Twig_SimpleFunction($name, $lambda));
        }

        return $twig;
    }
}
