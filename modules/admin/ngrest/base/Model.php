<?php

namespace admin\ngrest\base;

abstract class Model extends \yii\db\ActiveRecord
{
    abstract public function getNgRestApiEndpoint();
    
    abstract public function getNgRestPrimaryKey();
    
    abstract public function ngRestConfig($config);
    
    public function getNgRestConfig()
    {
        $config = new \admin\ngrest\Config($this->getNgRestApiEndpoint(), $this->getNgRestPrimaryKey());
        
        return $this->ngRestConfig($config);
    }
    
}