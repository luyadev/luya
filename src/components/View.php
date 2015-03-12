<?php
namespace luya\components;

use Yii;

class View extends \yii\web\View
{
    /**
     * @todo verify there is already a yii-way solution
     *
     * @param unknown $assetName
     */
    public function getAssetUrl($assetName)
    {
        return $this->assetBundles[$assetName]->baseUrl;
    }
}
