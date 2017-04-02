<?php

namespace admintests\data\stubs;

use luya\admin\ngrest\base\Plugin;

class StubPlugin extends Plugin
{
    public function renderList($id, $ngModel)
    {
        return 'render-list';
    }
    
    public function renderCreate($id, $ngModel)
    {
        return 'render-create';
    }
    
    public function renderUpdate($id, $ngModel)
    {
        return 'render-update';
    }
}
