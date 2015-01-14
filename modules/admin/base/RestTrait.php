<?php
namespace admin\base;

trait RestTrait
{
    public function actionIndex()
    {
        $this->throwException(__METHOD__);
    }

    public function actionView($id)
    {
        $this->throwException(__METHOD__);
    }

    public function actionUpdate($id)
    {
        $this->throwException(__METHOD__);
    }

    public function actionCreate($id)
    {
        $this->throwException(__METHOD__);
    }

    public function actionDelete($id)
    {
        $this->throwException(__METHOD__);
    }

    private function throwException($method)
    {
        throw new \Exception("The action ".$method." is not yet supported.");
    }
}
