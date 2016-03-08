<?php

namespace tests\web;

abstract class BaseModel extends \tests\web\Base
{
    public $createScenario = 'restcreate';

    public $updateScenario = 'restupdate';

    abstract public function getParams();

    abstract public function getModel();

    public function getInsert()
    {
        $i = [];
        foreach ($this->getParams() as $k => $v) {
            $i[$v] = $k;
        }

        return $i;
    }

    public function getUpdate()
    {
        $i = [];
        $p = 0;
        foreach (array_reverse($this->getInsert()) as $k => $v) {
            $i[$k] = $p;
            ++$p;
        }

        return $i;
    }

    public function testCrud()
    {
        $model = $this->getModel();

        $model->scenario = $this->createScenario;

        $model->attributes = $this->getInsert();
        $insert = $model->insert();

        $this->assertEquals(true, $insert);

        $pk = $model->getPrimaryKey();

        $update = $model::findOne($pk);
        $update->scenario = $this->updateScenario;
        $update->attributes = $this->getUpdate();

        $this->assertEquals(true, $update->update());
        $this->assertEquals(true, $update->delete());
    }
}
