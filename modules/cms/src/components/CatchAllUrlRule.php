<?php

namespace cms\components;

use Yii;

class CatchAllUrlRule extends \yii\web\UrlRule
{
    public $pattern = '<alias:(.*)+>';
    
    public $route = 'cms/default/index';
    
    public $encodeParams = false;
    
    public function parseRequest($manager, $request)
    {
        // add trace info
        Yii::info('LUYA-CMS CatchAllUrlRule is parsing the Request for path info \'' . $request->pathInfo .'\'', __METHOD__);
        
        if (empty($request->pathInfo)) {
            return false;
        }
        
        // return the custom route
        return ['/cms/default/index', ['path' => $request->pathInfo]];
    }
}