<?php
namespace admin\ngrest\base;

class Controller extends \admin\base\Controller
{
    public $modelClass = null;
    
    private $_model = null;

    public function getModelClass()
    {
        return $this->modelClass;
    }
    
    public function getModelObject()
    {
        if ($this->_model !== null) {
            return $this->_model;
        }
        
        $class = $this->getModelClass();
        
        $this->_model = new $class();
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
