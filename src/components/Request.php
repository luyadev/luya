<?php

namespace luya\components;

class Request extends \yii\web\Request
{
    public function isAdmin()
    {
        if ($this->getIsConsoleRequest()) {
            return false;
        }
        $parts = $this->getUrlParts();
        $first = reset($parts);
        
        if ($first == 'admin') {
            return true;
        }
        
        return false;
    }
    
    private function getUrlParts()
    {
        return explode('/', $this->getPathInfo());
    }
}