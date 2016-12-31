<?php

namespace luya\web;

use luya\traits\ApplicationTrait;

/**
 * Luya Web Application.
 *
 * @property \luya\web\Composition $composition Composition property
 * @property \luya\web\Twig $twig The twig component
 * @property \luya\web\Element $element The element component
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Application extends \yii\web\Application
{
    use ApplicationTrait;

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
                'appendTimestamp' => !YII_DEBUG,
            ],
        ]);
    }
}
