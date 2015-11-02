<?php

namespace cms\components;

class MenuQuery extends \yii\base\Object
{
    public $menu = null;
    
    public function where(array $args)
    {
        return $this;
    }
    
    public function one()
    {
        
    }
    
    public function all()
    {
        
    }
}