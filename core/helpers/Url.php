<?php

namespace luya\helpers;

use Yii;

/**
 * Helper methods when dealing with URLs and Links.
 *
 * Extends the {{yii\helpers\BaseUrl}} class by some usefull functions like:
 *
 * + {{luya\helpers\Url::trailing()}}
 * + {{luya\helpers\Url::toInternal()}}
 * + {{luya\helpers\Url::toAjax()}}
 * + {{luya\helpers\Url::ensureHttp()}}
 *
 * An example of create an URL based on Route in the UrlManager:
 *
 * ```php
 * Url::toRoute(['/module/controller/action']);
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Url extends \yii\helpers\BaseUrl
{
    /**
     * Add a trailing slash to an url if there is no trailing slash at the end of the url.
     *
     * @param string $url The url which a trailing slash should be appended
     * @param string $slash If you want to trail a file on a windows system it gives you the ability to add forward slashes.
     * @return string The url with added trailing slash, if requred.
     */
    public static function trailing($url, $slash = '/')
    {
        return rtrim($url, $slash) . $slash;
    }
    
    /**
     * This helper method will not concern any context informations
     *
     * @param array $routeParams Example array to route `['/module/controller/action']`.
     * @param boolean $scheme Whether to return the absolute url or not
     * @return string The created url.
     */
    public static function toInternal(array $routeParams, $scheme = false)
    {
        if ($scheme) {
            return Yii::$app->getUrlManager()->internalCreateAbsoluteUrl($routeParams);
        }
        
        return Yii::$app->getUrlManager()->internalCreateUrl($routeParams);
    }

    /**
     * Create a link to use when point to an ajax script.
     *
     * @param string $route  The base routing path defined in yii. module/controller/action
     * @param array $params Optional array containing get parameters with key value pairing
     * @return string The ajax url link.
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
     */
    public static function ensureHttp($url, $https = false)
    {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = ($https ? "https://" : "http://") . $url;
        }
        
        return $url;
    }

    /**
     * Removes schema, protocol and www. subdomain from host.
     * 
     * For example `https://luya.io/path` would return `luya.io/path`.
     *
     * @param string $url The url to extract
     * @return string returns the url without protocol or www. subdomain
     * @since 1.0.20
     */
    public static function cleanHost($url)
    {
        return str_replace(['www.', 'http://', 'https://'], '', Url::ensureHttp($url));
    }
    /**
     * Return only the domain of a path.
     * 
     * For example `https://luya.io/path` would return `luya.io` without path informations.
     *
     * @param string $url The url to extract
     * @return string Returns only the domain from the url.
     * @since 1.0.20
     */
    public static function domain($url)
    {
        return self::cleanHost(parse_url(Url::ensureHttp($url), PHP_URL_HOST));
    }
}
