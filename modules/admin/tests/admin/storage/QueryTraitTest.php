<?php

namespace tests\admin\storage;

use Yii;
use admintests\AdminTestCase;
use luya\admin\storage\QueryTrait;
use luya\admin\storage\IteratorAbstract;
use luya\admin\storage\ItemAbstract;
use yii\base\BaseObject;

class FixtureQueryTrait extends BaseObject
{
    use QueryTrait;
    
    public function getDataProvider()
    {
        return [
            1 => ['id' => 1, 'name' => 'Item 1', 'group' => 'A'],
            2 => ['id' => 2, 'name' => 'Item 2', 'group' => 'A'],
            3 => ['id' => 3, 'name' => 'Item 3', 'group' => 'B'],
        ];
    }
    
    public function getItemDataProvider($id)
    {
        return (isset($this->getDataProvider()[$id])) ? $this->getDataProvider()[$id] : false;
    }
    
    public function createItem(array $itemArray)
    {
        return FixtureItem::create($itemArray);
    }
    
    public function createIteratorObject(array $data)
    {
        return Yii::createObject(['class' => FixtureIterator::className(), 'data' => $data]);
    }
}

class FixtureItem extends ItemAbstract
{
    public function getId()
    {
        return $this->itemArray['id'];
    }
    
    public function getName()
    {
        return $this->itemArray['name'];
    }
    
    public function getGroup()
    {
        return $this->itemArray['group'];
    }
    
    public function fields()
    {
        return ['id', 'name', 'group'];
    }
}

class FixtureIterator extends IteratorAbstract
{
    /**
     * Iterator get current element, generates a new object for the current item on access.
     *
     * @return \cms\menu\Item
     */
    public function current()
    {
        return FixtureItem::create(current($this->data));
    }
}

// TEST CASE

class QueryTraitTest extends AdminTestCase
{
    public function testQueryCount()
    {
        $this->assertEquals(3, (new FixtureQueryTrait())->count());
        $this->assertEquals(false, (new FixtureQueryTrait())->where(['id' => 0])->count());
        $this->assertEquals(false, (new FixtureQueryTrait())->where(['id' => 0])->one());
        $this->assertEquals(0, count((new FixtureQueryTrait())->where(['id' => 0])->all()));
        $this->assertEquals(3, count((new FixtureQueryTrait())->all()));
        $this->assertEquals(1, count((new FixtureQueryTrait())->one()));
        $this->assertEquals(1, (new FixtureQueryTrait())->findOne(1)->id);
        $this->assertEquals(3, (new FixtureQueryTrait())->findOne(3)->id);
        $this->assertEquals(1, count((new FixtureQueryTrait())->findOne(1)));
        $this->assertEquals(false, (new FixtureQueryTrait())->findOne(0));
        $this->assertEquals(1, (new FixtureQueryTrait())->where(['id' => 1])->count());
        $this->assertEquals(1, count((new FixtureQueryTrait())->where(['id' => 1])->all()));
    }
    
    public function testWhereConditions()
    {
        $this->assertEquals(0, (new FixtureQueryTrait())->where(['id' => 1, 'name' => 'Item 2'])->count());
        $this->assertEquals(1, (new FixtureQueryTrait())->where(['id' => 1, 'name' => 'Item 1'])->count());
        $this->assertEquals(2, (new FixtureQueryTrait())->where(['group' => 'A'])->count());
        $this->assertEquals(2, count((new FixtureQueryTrait())->where(['group' => 'A'])->all()));
        $this->assertEquals(1, count((new FixtureQueryTrait())->where(['group' => 'A'])->one()));
    }
    
    public function testWhereOperatorConditions()
    {
        $this->assertEquals(1, (new FixtureQueryTrait())->where(['==', 'id', 1])->count());
        $this->assertEquals(0, (new FixtureQueryTrait())->where(['==', 'id', '1'])->count());
        $this->assertEquals(1, (new FixtureQueryTrait())->where(['=', 'id', 1])->count());
        $this->assertEquals(1, (new FixtureQueryTrait())->where(['=', 'id', '1'])->count());
        $this->assertEquals(3, (new FixtureQueryTrait())->where(['>=', 'id', 1])->count());
        $this->assertEquals(2, (new FixtureQueryTrait())->where(['>', 'id', 1])->count());
        $this->assertEquals(3, (new FixtureQueryTrait())->where(['<=', 'id', 3])->count());
        $this->assertEquals(2, (new FixtureQueryTrait())->where(['<', 'id', 3])->count());
        
        $this->assertEquals(1, (new FixtureQueryTrait())->where(['>', 'id', 1])->andWhere(['==', 'group', 'B'])->count());
    }
    
    public function testWhereInOperatorConditions()
    {
        $x = (new FixtureQueryTrait())->where(['in', 'id', [1, 3]])->all();
        
        $this->assertEquals(2, count($x));
            
        
        $i = 0;
        foreach ($x as $k => $v) {
            if ($i == 0) {
                $this->assertEquals(1, $v->id);
            } else {
                $this->assertEquals(3, $v->id);
            }
            
            $i++;
        }
    }
    
    public function testIterator()
    {
        $b = (new FixtureQueryTrait())->where(['group' => 'B'])->all();

        $this->assertEquals(1, count($b));
        foreach ($b as $item) {
            $this->assertEquals(3, $item->id);
            $this->assertEquals('B', $item->group);
            $this->assertEquals('Item 3', $item->name);
            
            $this->assertArrayHasKey('id', $item->toArray());
            $this->assertArrayHasKey('group', $item->toArray());
            $this->assertArrayHasKey('name', $item->toArray());
        }
    }
    
    public function testLimit()
    {
        $this->assertEquals(2, count((new FixtureQueryTrait())->limit(2)->all()));
        $this->assertEquals(1, count((new FixtureQueryTrait())->limit(1)->all()));
        
        $items = (new FixtureQueryTrait())->where(['>', 'id', 1])->limit(1)->all();

        $this->assertEquals(1, count($items));
        
        foreach ($items as $item) {
            $this->assertEquals(2, $item->id);
        }
    }
    
    public function testOffset()
    {
        $items = (new FixtureQueryTrait())->where(['>', 'id', 1])->offset(1)->limit(1)->all();
        
        $this->assertEquals(1, count($items));
        
        foreach ($items as $item) {
            $this->assertEquals(3, $item->id);
        }
    }
}
