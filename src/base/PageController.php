<?php
namespace luya\base;

class PageController extends \luya\base\Controller implements \yii\base\ViewContextInterface
{
    public $pageTitle = '';

    public $pageMeta = [];

    public $propertyMap = [
        'pageTitle', 'pageMeta',
    ];
}
