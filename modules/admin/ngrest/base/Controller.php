<?php
namespace admin\ngrest\base;

class Controller extends \admin\base\Controller
{
    public $modelClass = null;

    public function getModelClass()
    {
        return $this->modelClass;
    }
    
    public function actionIndex()
    {
        $class = $this->getModelClass();
        $model = new $class();
        $ngrest = new \admin\ngrest\NgRest($model->getNgRestConfig());
        
        return $ngrest->render(new \admin\ngrest\render\RenderCrud());
    }
}