<?php

namespace luya\components;

use Yii;
use luya\helpers\Url;

class View extends \yii\web\View
{
    /**
     * @todo verify there is already a yii-way solution
     *
     * @param string $assetName
     *
     * @return string
     */
    public function getAssetUrl($assetName)
    {
        return $this->assetBundles[$assetName]->baseUrl;
    }

    /**
     * Removes redundant whitespaces (>1) and new lines (>1)
     * 
     * @param string $content input string
     * @return string compressed string
     */
    public function compress($content)
    {
        return preg_replace(array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s'), array('>', '<', '\\1'), $content);
    }

    /**
     * Helper method for convenience.
     *
     * @param string $route
     * @param array  $params
     *
     * @return string
     */
    public function url($route, array $params = [])
    {
        return Url::to($route, $params);
    }
}
