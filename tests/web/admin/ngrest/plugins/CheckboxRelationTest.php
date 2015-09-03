<?php

namespace tests\web\admin\ngrest\plugins;

class CheckboxRelationTest extends \tests\web\Base
{
    public function testCheckboxReleation()
    {
        $obj = new \admin\ngrest\plugins\CheckboxRelation('\\tests\\data\\models\\UserModel', 'a', 'b', 'c', ['firstname', 'lastname']);
        $service = $obj->serviceData();
        $this->assertArrayHasKey('relationdata', $service);
        $this->assertArrayHasKey('items', $service['relationdata']);
    }
}
