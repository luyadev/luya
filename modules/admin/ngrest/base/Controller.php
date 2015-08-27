<?php

namespace admin\ngrest\base;

use Yii;

class Controller extends \admin\base\Controller
{
    public $modelClass = null;

    public $disablePermissionCheck = true;

    private $_model = null;

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function getModelObject()
    {
        if ($this->_model === null) {
            $this->_model = Yii::createObject($this->getModelClass());
        }

        return $this->_model;
    }

    public function getNgRestConfig()
    {
        return $this->getModelObject()->getNgRestConfig();
    }

    public function actionIndex()
    {
        $ngrest = new \admin\ngrest\NgRest($this->getNgRestConfig());

        return $ngrest->render(new \admin\ngrest\render\RenderCrud());
    }
}
