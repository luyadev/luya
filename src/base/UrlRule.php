<?php
namespace luya\base;

abstract class UrlRule extends \yii\web\UrlRule
{
    public function init()
    {
        // dot not exec parent initializers
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
