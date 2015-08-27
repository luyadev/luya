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

        $pathInfo = Yii::$app->composition->getResolvedPathInfo($this);

        $parts = explode('/', $pathInfo);
        $first = reset($parts);

        if ($first == 'admin') {
            return true;
        }

        return false;
    }
}
