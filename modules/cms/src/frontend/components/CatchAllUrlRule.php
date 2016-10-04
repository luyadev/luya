<?php

namespace luya\cms\frontend\components;

use Yii;

/**
 * CMS UrlRule who catches all calls in order to allow cms oversteering of not previous catched requests of other url rules.
 *
 * The CatchAllUrlRule must be the LAST UrlRule of the UrlManager.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class CatchAllUrlRule extends \yii\web\UrlRule
{
    public $pattern = '<alias:(.*)+>';
    
    public $route = 'cms/default/index';
    
    public $encodeParams = false;
    
    /**
     * {@inheritDoc}
     * @see \yii\web\UrlRule::parseRequest()
     */
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
