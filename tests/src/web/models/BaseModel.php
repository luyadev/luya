<?php

namespace tests\src\web\models;


abstract class BaseModel extends \tests\BaseWebTest
{
    abstract public function getParams();
    
    abstract public function getModel();
    
    public function getInsert()
    {
        $i = [];
        foreach($this->getParams() as $k => $v) {
            $i[$v] = $k;
        }
        return $i;
    }
    
    public function getUpdate()
    {
        $i = [];
        $p = 0;
        foreach(array_reverse($this->getInsert()) as $k => $v) {
            $i[$k] = $p;
            $p++;
        }
        
        return $i;
    }
    
    public function testCrud()
    {
        $model = $this->getModel();
        
        $model->scenario = 'restcreate';
        
        $model->attributes = $this->getInsert();
        $insert = $model->insert();
        
        $this->assertEquals(true, $insert);
        
        $pk = $model->getPrimaryKey();
        
        $update = $model::findOne($pk);
        $update->scenario = 'restupdate';
        $update->attributes = $this->getUpdate();
        
        $this->assertEquals(true, $update->update());
        $this->assertEquals(true, $update->delete());
    }
}