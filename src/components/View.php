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
