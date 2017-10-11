<?php

namespace admintests\admin\ngrest\render;

use admintests\AdminTestCase;
use luya\admin\ngrest\render\RenderCrud;

class RenderCrudTest extends AdminTestCase
{
    /**
     *
     * @return \luya\admin\ngrest\render\RenderCrud
     */
    protected function getCrud()
    {
        return new RenderCrud();
    }
    
    public function testSettingButtonDefintion()
    {
        $crud = $this->getCrud();
        $crud->setSettingButtonDefinitions([
            ['label' => 'foo', 'tag' => 'span', 'ng-href' => '#click', 'class' => 'foobar'],
        ]);
        
        $this->assertSame([
            '<span class="foobar" label="foo" ng-href="#click"><i class="material-icons">extension</i><span> foo</span></span>',
        ], $crud->getSettingButtonDefinitions());
    }
}
