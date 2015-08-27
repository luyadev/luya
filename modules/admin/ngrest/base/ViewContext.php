<?php

namespace admin\ngrest\base;

use Yii;

class ViewContext implements \yii\base\ViewContextInterface
{
    public $module = null;

    public $id = null;

    public function getViewPath()
    {
        if (substr($this->module, 0, 1) !== '@') {
            $module = '@'.$this->module;
        } else {
            $module = $this->module;
        }

        return Yii::getAlias($module).DIRECTORY_SEPARATOR.'views/aws'.DIRECTORY_SEPARATOR.$this->id;
    }
}
