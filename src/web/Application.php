<?php

namespace luya\web;

/**
 * @property \luya\web\components\Composition $composition Composition property
 * @author nadar
 *
 */
class Application extends \yii\web\Application
{
    use \luya\traits\Application;
    
    /**
     * @inheritdoc
     */
    public function coreComponents()
    {
        return array_merge($this->luyaCoreComponents(), [
            'request' => ['class' => 'luya\web\components\Request'],
            'errorHandler' => ['class' => 'luya\web\components\ErrorHandler'],
            'urlManager' => ['class' => 'luya\web\components\UrlManager'],
            'view' => ['class' => 'luya\web\components\View'],
            'assetManager' => [
                'class' => 'luya\web\components\AssetManager',
                'forceCopy' => YII_DEBUG,
                'appendTimestamp' => !YII_DEBUG
            ],
        ]);
    }
}
