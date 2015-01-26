<?php
namespace luya\base;

abstract class Collection extends \yii\base\Component
{
    protected $prevObject = false;

    public function setPrevObject($prevObject)
    {
        $this->prevObject = $prevObject;
    }

    public function getPrevObject()
    {
        return $this->prevObject;
    }
}
