<?php

namespace admintests\admin\ngrest\base;

use admintests\AdminTestCase;
use admintests\data\fixtures\TagFixture;
use admintests\data\models\TestNgRestModel;
use admintests\data\models\TestNewNotationNgRestModel;

class NgRestModelTest extends AdminTestCase
{
    public function testScenarios()
    {
        $model = new TagFixture();
        $model->load();
        $tag = $model->getModel('tag1');
        $scenes = $tag->scenarios();
        
        $this->assertSame(3, count($scenes));

        $this->assertSame($scenes['default'], $scenes['restcreate']);
        $this->assertSame($scenes['default'], $scenes['restupdate']);
        $this->assertSame($scenes['restcreate'], $scenes['restcreate']);
    }
    
    public function testGenericSearchFields()
    {
        $model = new TagFixture();
        $model->load();
        $tag = $model->getModel('tag1');
        
        $this->assertSame(['name'], $tag->genericSearchFields());
    }
    
    public function testGenericSearch()
    {
        $model = new TagFixture();
        $model->load();
        $tag = $model->getModel('tag1');
        $results = $tag->genericSearch('John');

        $this->assertSame(1, count($results));
        
        $this->assertSame('john', $results[0]->name);
    }
    
    public function testGetNgRestConfig()
    {
        $model = new TestNgRestModel();
        
        $array = $model->getNgRestConfig()->getConfig();

        $this->assertArrayHasKey('foo', $array['list']);
        $this->assertArrayHasKey('bar', $array['list']);
        $this->assertArrayHasKey('extraAttr', $array['list']);
        
        $this->assertArrayHasKey('foo', $array['update']);
        $this->assertArrayNotHasKey('bar', $array['update']);
        $this->assertArrayNotHasKey('extraAttr', $array['update']);
        
        $this->assertArrayHasKey('foo', $array['create']);
        $this->assertArrayNotHasKey('bar', $array['create']);
        $this->assertArrayNotHasKey('extraAttr', $array['create']);
        
        $this->assertTrue($array['delete']);
        
        $this->assertArrayHasKey('aw', $array);
        $this->assertArrayHasKey('20bfd729bb01954cea413f6cfc3bcf6c77b25ed3', $array['aw']);
    }
    
    public function testCompareNewAndOldConfig()
    {
        $old = new TestNgRestModel();
        $oldArray = $old->getNgRestConfig()->getConfig();
        
        unset($oldArray['aw']['20bfd729bb01954cea413f6cfc3bcf6c77b25ed3']['objectConfig']['ngRestModelClass']);
        
        $new = new TestNewNotationNgRestModel();
        $newArray = $new->getNgRestConfig()->getConfig();
        
        unset($newArray['aw']['20bfd729bb01954cea413f6cfc3bcf6c77b25ed3']['objectConfig']['ngRestModelClass']);
        
        $this->assertSame($oldArray, $newArray);
    }
}
