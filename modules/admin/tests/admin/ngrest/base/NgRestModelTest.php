<?php

namespace admintests\admin\ngrest\base;

use admintests\AdminTestCase;
use admintests\data\fixtures\TagFixture;

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
}