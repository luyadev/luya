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
            'request' => ['class' => 'luya\web\Request'],
            'errorHandler' => ['class' => 'luya\web\ErrorHandler'],
            'urlManager' => ['class' => 'luya\web\UrlManager'],
            'view' => ['class' => 'luya\web\View'],
            'element' => ['class' => 'luya\web\Element'],
            'twig' => ['class' => 'luya\web\Twig'],
            'composition' => ['class' => 'luya\web\Composition'],
            'assetManager' => [
                'class' => 'luya\web\AssetManager',
                'forceCopy' => YII_DEBUG,
                'appendTimestamp' => !YII_DEBUG
            ],
        ]);
    }
}
