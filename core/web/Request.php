<?php

namespace luya\web;

use Yii;

/**
 * Luya Request Component to provide a differentiation for frontend/admin context.
 *
 * @author nadar
 */
class Request extends \yii\web\Request
{
    /**
     * @var bool force web request to enable unit tests with simulated web requests
     */
    public $forceWebRequest = false;

    public $cookieValidationKey = 'luya-1.0.0-beta5-cookie-validation-key';
    
    public $parsers = [
        'application/json' => 'yii\web\JsonParser',
    ];

    /**
     * Resolve the current url request and check if admin context.
     *
     * @return bool if admin context available?
     */
    public function isAdmin()
    {
        if ($this->getIsConsoleRequest() && !$this->forceWebRequest) {
            return false;
        }

        $resolver = Yii::$app->composition->getResolvedPathInfo($this);

        $pathInfo = $resolver['route'];
        $parts = explode('/', $pathInfo);
        $first = reset($parts);

        if ($first == 'admin') {
            return true;
        }

        return false;
    }
}
