<?php

namespace luyatests\data\aws;

class ActiveWindowExample extends \admin\ngrest\base\ActiveWindow
{
    public $module = 'unitmodule';

    public function index()
    {
        return 'index';
    }
}
