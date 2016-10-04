<?php

namespace luya\helpers;

use Yii;

/**
 * URL Helper to create URLs and other tools.
 *
 * This Class extends the \yii\helpers\Url class which provides tools to create URLs based on the
 * URL-Manager component. There are also other little helper methods to work with urls.
 *
 * An example of create an URL based on Route in the UrlManager:
 *
 * ```php
 * Url::toRoute(['/module/controller/action']);
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Url extends \yii\helpers\Url
{
    /**
     * Add a trailing slash to an url if there is no trailing slash at the end of the url.
     *
     * @param string $url   The url which a trailing slash should be appended
     * @param string $slash If you want to trail a file on a windows system it gives you the ability to add forward slashes.
     */
    public static function trailing($url, $slash = '/')
    {
        return $url.(substr($url, -1) == $slash ? '' : $slash);
    }

    /**
     * This helper method will not concern any context informations
     *
     * @param array $routeParams Example array to route `['/module/controller/action']`.
     * @param boolean $scheme Whether to return the absolute url or not
     */
    public static function toInternal(array $routeParams, $scheme = false)
    {
        if ($scheme) {
            return Yii::$app->getUrlManager()->internalCreateAbsoluteUrl($routeParams);
        }
        
        return Yii::$app->getUrlManager()->internalCreateUrl($routeParams);
    }
    
    /**
     * Only stil exists to avoid bc break, former known as `to()`. Use `Url::toRoute(['/module/controller/action', 'arg1' => 'arg1value']);` instead.
     * Wrapper functions for the createUrl function of the url manager.
     *
     * @param string $route
     * @param array  $params
     * @param boolean $sheme Whether to return static url or not
     * @todo we have to remove this method as it provides no additinal functions to the yii\helpers\url to method
     */
    public static function toManager($route, array $params = [], $scheme = false)
    {
        $routeParams = [$route];
        foreach ($params as $key => $value) {
            $routeParams[$key] = $value;
        }

        if ($scheme) {
            return Yii::$app->getUrlManager()->createAbsoluteUrl($routeParams);
        }
        
        return Yii::$app->getUrlManager()->createUrl($routeParams);
    }

    /**
     * Create a link to use when point to an ajax script.
     *
     * @param string $route  The base routing path defined in yii. module/controller/action
     * @param array  $params Optional array containing get parameters with key value pairing
     * @return string
     */
    public static function toAjax($route, array $params = [])
    {
        $routeParams = ['/'.$route];
        foreach ($params as $key => $value) {
            $routeParams[$key] = $value;
        }
        
        return static::toInternal($routeParams, true);
    }
    
    /**
     * Apply the http protcol to an url to make sure valid clickable links. Commonly used when provide link where user could have added urls
     * in an administration area. For Example:
     *
     * ```php
     * Url::ensureHttp('luya.io'); // return http://luya.io
     * Url::ensureHttp('www.luya.io'); // return https://luya.io
     * Url::ensureHttp('luya.io', true); // return https://luya.io
     * ```
     *
     * @param string $url The url where the http protcol should be applied to if missing
     * @param boolean $https Whether the ensured url should be returned as https or not.
     * @return string
     * @since 1.0.0-beta7
     */
    public static function ensureHttp($url, $https = false)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = ($https ? "https://" : "http://") . $url;
        }
        
        return $url;
    }
}
