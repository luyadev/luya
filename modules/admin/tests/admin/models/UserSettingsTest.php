<?php

namespace admintests\models;

use admintests\AdminTestCase;
use luya\admin\models\UserSetting;

class UserSettingsTest extends AdminTestCase
{
    public function testArraySetter()
    {
        $model = new UserSetting();
        
        // test set
        $this->assertTrue($model->set('1.1', 'value'));
        $this->assertTrue($model->set('1.2', 'value2'));
        $this->assertTrue($model->set('key', 'value'));
        $this->assertTrue($model->set('x.y.1', 'v1'));
        $this->assertTrue($model->set('x.y.2', 'v2'));
        $this->assertFalse($model->set('x.y.2.b', '2_is_already_a_value_not_able_to_set_this_value'));
        $this->assertTrue($model->set('one.two.three', 'four'));
        $this->assertTrue($model->set('cfg.override', 1));
        
        // inspect array data
        $this->assertArrayHasKey('1', $model->data);
        $this->assertArrayHasKey('key', $model->data);
        $this->assertArrayHasKey('x', $model->data);
        $this->assertArrayHasKey('1', $model->data[1]);
        $this->assertArrayHasKey('2', $model->data[1]);
        $this->assertArrayHasKey('y', $model->data['x']);
        $this->assertArrayHasKey('1', $model->data['x']['y']);
        $this->assertArrayHasKey('2', $model->data['x']['y']);
     
        // test get
        $this->assertEquals(null, $model->get('notfound'));
        $this->assertEquals(false, $model->get('notfound', false));
        $this->assertEquals('value', $model->get('1.1'));
        $this->assertEquals('value2', $model->get('1.2'));
        $this->assertEquals('value', $model->get('key'));
        $this->assertEquals('v1', $model->get('x.y.1'));
        $this->assertEquals('v2', $model->get('x.y.2'));
        $this->assertArrayHasKey('y', $model->get('x'));
        $this->assertArrayHasKey('1', $model->get('x.y'));
        $this->assertEquals(1, $model->get('cfg.override'));
        
        $this->assertTrue($model->set('cfg.override', 2));
        $this->assertEquals(2, $model->get('cfg.override'));
        
        // test has
        $this->assertFalse($model->has('does.not.exists'));
        $this->assertFalse($model->has('does.not'));
        $this->assertFalse($model->has('does'));
        $this->assertTrue($model->has('key'));
        $this->assertTrue($model->has('x.y.1'));
        $this->assertFalse($model->has('x.y.3'));
        $this->assertFalse($model->has('x.y.1.b'));
        $this->assertFalse($model->has('x.y.2.b'));

        // remove elements and test with has
        $this->assertTrue($model->has('one.two.three'));
        $this->assertTrue($model->has('one.two'));
        $this->assertTrue($model->has('one'));
        $model->remove('one.two.three');
        $this->assertFalse($model->has('one.two.three'));
        $model->remove('one');
        $this->assertFalse($model->has('one.two.three'));
        $this->assertFalse($model->has('one.two'));
        $this->assertFalse($model->has('one'));
        
        // remove not existing element
        $this->assertFalse($model->remove('not.existing.element.somewhere'));
        $this->assertFalse($model->remove('notexisting'));
    }
    
    public function testUnsetRemoveElement()
    {
        $model = new UserSetting();
        $this->assertFalse($model->remove('not_exists'));
    }
    
    public function testArraySetterArrayAccess()
    {
        $model = new UserSetting();
    
        $model['1.2.3'] = 'value';
        
        $this->assertEquals('value', $model['1.2.3']);
        $this->assertFalse(isset($model['1.2.3.4']));
        $this->assertTrue(isset($model['1.2.3']));
        
        unset($model['1.2']);
        $this->assertFalse(isset($model['1.2']));
        $this->assertTrue(isset($model['1']));
    }
}
