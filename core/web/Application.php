<?php

namespace luya\web;

use luya\traits\ApplicationTrait;

/**
 * Luya Web Application.
 *
 *
 * @property \luya\cms\Menu $menu Menu component in order to build navigation from CMS module.
 * @property \luya\admin\storage\BaseFileSystemStorage $storage Storage component for reading, saving and holding files from the Admin module.
 * @property \luya\web\Composition $composition Composition component.
 * @property \luya\web\Element $element The element component.
 * @property \luya\web\View $view The view component.
 * @property \luya\web\Request $request The request component.
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
            'composition' => ['class' => 'luya\web\Composition'],
            'assetManager' => [
                'class' => 'luya\web\AssetManager',
                'forceCopy' => YII_DEBUG,
                'appendTimestamp' => !YII_DEBUG,
            ],
        ]);
    }
}
