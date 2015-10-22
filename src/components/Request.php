<?php

namespace luya\components;

use Yii;

/**
 * Luya Request Component to provide a differentiation for frontend/admin context
 *
 * @author nadar
 */
class Request extends \yii\web\Request
{
    /**
     * @var boolean force web request to enable unit tests with simulated web requests
     */
    public $forceWebRequest = false;

    /**
     * Resolve the current url request and check if admin context.
     *
     * @return boolean if admin context available?
     *
     */
    public function isAdmin()
    {
        if ($this->getIsConsoleRequest() && !$this->forceWebRequest) {
            return false;
        }

        $resolver = Yii::$app->composition->getResolvedPathInfo($this);

        $first = reset(explode('/', $resolver['route']));

        if ($first == 'admin') {
            return true;
        }

        return false;
    }
}
