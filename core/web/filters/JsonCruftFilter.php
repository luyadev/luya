<?php

namespace luya\web\filters;

use Yii;
use yii\base\ActionFilter;
use yii\web\Response;

/**
 * Json Cruft Filter.
 * 
 * This ActionFilter will append the {{luya\web\filters\JsonCruftFilter::$cruft}} string before every request
 * in order to disallow json hijacking.
 * 
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'class' => luya\web\filters\JsonCruftFilter::class,
 *     ];
 * }
 * ```
 * 
 * On the client side (example using angular) you have to remove the cruft string from every response content
 * in order to have a valid json response.
 * 
 * @see http://blog.portswigger.net/2016/11/json-hijacking-for-modern-web.html
 * @see https://stackoverflow.com/a/3270390
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.7
 */
class JsonCruftFilter extends ActionFilter
{
    /**
     * @var string The curft string which is appended to every json rest response.
     */
    public $cruft = 'throw 1;<dont be evil>';
    
    public function getCruftLength()
    {
        return strlen($this->cruft);
    }
    
    public function prependCruft($content)
    {
        return $this->cruft . trim($content);
    }
    
    public function afterAction($action, $result)
    {
        if (Yii::$app->response->format == Response::FORMAT_JSON) {
            return $this->prependCruft($result);    
        }
        
        return $result;
    }
}