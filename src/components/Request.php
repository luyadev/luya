<?php

namespace luya\components;

use Yii;

class Request extends \yii\web\Request
{
    public $forceWebRequest = false;

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
