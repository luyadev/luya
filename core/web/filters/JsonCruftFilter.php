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
 * AngularJs built in protection: https://docs.angularjs.org/api/ng/service/$http#interceptors => JSON Vulnerability Protection
 *
 * @see http://blog.portswigger.net/2016/11/json-hijacking-for-modern-web.html
 * @see https://stackoverflow.com/a/3270390
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.7
 */
class JsonCruftFilter extends ActionFilter
{
    const CRUFT_HEADER_NAME = 'X-CRUFT-LENGTH';

    /**
     * @var array A list of status codes which does not need cruft prepend as it has by defintion no content.
     * @since 1.6.2
     */
    public $ignoreStatusCodes = [204];
    
    /**
     * @var string The curft string which is appended to every json rest response.
     */
    public $cruft = ")]}',\n";
    
    /**
     * Get the string lengt from the cruf.
     *
     * @return number
     */
    public function getCruftLength()
    {
        return strlen($this->cruft);
    }
    
    /**
     * Prepend the cruft string to a given content.
     *
     * @param string $content
     * @return string
     */
    public function prependCruft($content)
    {
        return $this->cruft . trim($content);
    }
    
    /**
     * @inheritdoc
     */
    public function afterAction($action, $result)
    {
        if (Yii::$app->response->format == Response::FORMAT_JSON && !in_array(Yii::$app->response->statusCode, $this->ignoreStatusCodes)) {
            Yii::$app->response->headers->set(self::CRUFT_HEADER_NAME, $this->getCruftLength());
            Yii::$app->response->on(Response::EVENT_AFTER_PREPARE, function ($event) {
                $event->sender->content = $this->prependCruft($event->sender->content);
            });
        }
        
        return $result;
    }
}
