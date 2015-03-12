<?php
namespace luya\components;

use Yii;

class UrlRule extends \luya\base\UrlRule
{
    public function init()
    {
        // override previous UrlRule initializer
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $parts = explode("/", $request->getPathInfo());

        preg_match_all('/<(\w+):?([^>]+)?>/', yii::$app->getModule('luya')->urlPrefixComposition, $matches, PREG_SET_ORDER);

        $compositionKeys = [];

        foreach ($matches as $index => $match) {
            if (isset($parts[$index])) {
                $urlValue = $parts[$index];
                $rgx = $match[2];
                $param = $match[1];
                preg_match("/^$rgx$/", $urlValue, $res);

                if (count($res) == 1) {
                    $compositionKeys[$param] = $urlValue;
                    unset($parts[$index]);
                }
            }
        }

        $request->setPathInfo(implode("/", $parts));

        $composition = new \luya\collection\PrefixComposition();
        $composition->set($compositionKeys);

        Yii::$app->collection->composition = $composition;

        /* new get default url route @ 07.01.2015 */

        $parts = explode("/", $request->getPathInfo()); // can be deleted after reshuffle array

        if (!empty($parts) && !array_key_exists($parts[0], yii::$app->modules)) {
            $class = yii::$app->defaultRoute.'\components\UrlRule';
            $manager->addRules([['class' => $class]], false);

            return $manager->parseRequest($request);
        }

        return false;
    }
}
