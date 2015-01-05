<?php
namespace luya\base;

abstract class UrlRule extends \yii\web\UrlRule
{
    public function init()
    {
        // we do not have automatic initialising of patterns
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    public function parseRequest($manager, $request)
    {
        return false;
    }
}
