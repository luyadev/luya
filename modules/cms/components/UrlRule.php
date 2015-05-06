<?php

namespace cms\components;

class UrlRule extends \luya\base\UrlRule
{
    public function init()
    {
    }

    public function createUrl($manager, $route, $params)
    {
        return false;
    }

    public function parseRequest($manager, $request)
    {
        return ['cms/default/index', ['path' => $request->getPathInfo()]];
    }
}
