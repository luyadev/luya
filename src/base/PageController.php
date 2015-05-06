<?php

namespace luya\base;

class PageController extends \luya\base\Controller implements \yii\base\ViewContextInterface
{
    public $pageTitle = null;

    public $propertyMap = [
        'pageTitle',
    ];
}
