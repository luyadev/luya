<?php

namespace tests\data;

class ActiveWIndowExample extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'unitmodule';
    
    public function index()
    {
        return 'index';
    }
}